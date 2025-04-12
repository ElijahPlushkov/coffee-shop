<?php
header('Content-Type: text/html; charset=utf-8');

$searchTerm = $_GET['query'] ?? '';

$ordersFile = 'orders.json';
$allOrders = [];

if (file_exists($ordersFile)) {
    $jsonData = file_get_contents($ordersFile);
    $allOrders = json_decode($jsonData, true) ?? [];
}

$filteredOrders = array_filter($allOrders, function ($order) use ($searchTerm) {
   if (empty($searchTerm)) {
       return false;
   }

   $searchFields = ['id', 'email', 'city', 'address'];
   foreach ($searchFields as $field) {
       if (stripos($order[$field] ?? '', $searchTerm) !== false) {
           return true;
       }
   }
   return false;
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<form method="get" class="container mt-2">
    <h1>Order Search</h1>
    <input type="text" name="query" value="<?= htmlspecialchars($searchTerm) ?>">
    <button type="submit">Search</button>
</form>

<div class="container">
<?php if (!empty($searchTerm)): ?>
    <h2>Results for "<?= htmlspecialchars($searchTerm) ?>"</h2>
    <?php if (empty($filteredOrders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Email</th>
                <th>City</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
            <?php foreach ($filteredOrders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['city'] ?? '') ?></td>
                    <td>$<?= number_format($order['totalPrice'] ?? 0, 2) ?></td>
                    <td><?= htmlspecialchars($order['date'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<a href="http://localhost:8080/Coffee%20Shop/" class="btn btn-primary mt-3">Вернуться на главную</a>
</div>
</body>
</html>

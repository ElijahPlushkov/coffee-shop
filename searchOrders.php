<?php
header('Content-Type: text/html; charset=utf-8');

$searchTerm = $_GET['query'] ?? '';
$sortOrder = $_GET['sort'] ?? 'newest';

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

usort($filteredOrders, function($a, $b) use ($sortOrder) {
   $dateA = strtotime($a['date']);
   $dateB = strtotime($b['date']);

   return ($sortOrder === 'newest') ? $dateB <=> $dateA : $dateA <=> $dateB;
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<form method="get" class="container mt-2">
    <h1>Order Search</h1>
    <input type="text" name="query" value="<?= htmlspecialchars($searchTerm) ?>">
    <button type="submit">Search</button>

    <select name="sort">
        <option value="newest" <?= $sortOrder === 'newest' ? 'selected' : '' ?>>Newest First</option>
        <option value="oldest" <?= $sortOrder === 'oldest' ? 'selected' : '' ?>>Oldest First</option>
    </select>
</form>

<div class="container">
<?php if (!empty($searchTerm)): ?>
    <h2>Results for "<?= htmlspecialchars($searchTerm) ?>"</h2>
    <?php if (empty($filteredOrders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-success">
            <tr>
                <th>Order ID</th>
                <th>Email</th>
                <th>City</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($filteredOrders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['city'] ?? '') ?></td>
                    <td>$<?= number_format($order['totalPrice'] ?? 0, 2) ?></td>
                    <td><?= htmlspecialchars($order['date'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>

<a href="http://localhost:8080/Coffee%20Shop/" class="btn btn-primary mt-3">Вернуться на главную</a>
</div>
</body>
</html>

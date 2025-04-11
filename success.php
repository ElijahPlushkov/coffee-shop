<?php
header('Content-Type: text/html; charset=utf-8');

if (!isset($_GET['status'])) {
    die('<h1>Ошибка: статус оплаты не указан</h1>');
}

$ordersFile = 'orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];

$currentOrder = null;
if (isset($_GET['payment_id'])) {
    foreach ($orders as $order) {
        if ($order['id'] === $_GET['payment_id']) {
            $currentOrder = $order;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="order-card card mt-5">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0">Заказ успешно оформлен!</h2>
        </div>
        <div class="card-body">
            <?php if ($currentOrder): ?>
                <div class="alert alert-success">
                    <p>Спасибо за ваш заказ! Номер вашего заказа: <strong><?= htmlspecialchars($currentOrder['id']) ?></strong></p>
                    <p>Мы отправили подтверждение на email: <strong><?= htmlspecialchars($currentOrder['email']) ?></strong></p>
                </div>

                <h4>Детали заказа:</h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <strong>Адрес доставки:</strong><br>
                        <?= htmlspecialchars($currentOrder['address']) ?><br>
                        <?= htmlspecialchars($currentOrder['address2']) ?><br>
                        <?= htmlspecialchars($currentOrder['city']) ?>, <?= htmlspecialchars($currentOrder['zip']) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Товары:</strong> <?= htmlspecialchars($currentOrder['items']) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Количество:</strong> <?= htmlspecialchars($currentOrder['totalQuantity']) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Сумма заказа:</strong> $<?= htmlspecialchars($currentOrder['totalPrice']) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Дата заказа:</strong> <?= htmlspecialchars($currentOrder['date']) ?>
                    </li>
                </ul>
            <?php else: ?>
                <div class="alert alert-warning">
                    Информация о заказе не найдена.
                </div>
            <?php endif; ?>

            <a href="http://localhost:8080/Coffee%20Shop/" class="btn btn-primary">Вернуться на главную</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST allowed']);
    exit;
}

sleep(2);

$input = json_decode(file_get_contents('php://input'), true);

$order = [
    'id' => 'fp_' . time() . '_' . rand(1000, 9999),
    'email' => $input['email'] ?? $_POST['email'] ?? 'unknown',
    'address' => $input['address'] ?? $_POST['address'] ?? 'unknown',
    'address2' => $input['address2'] ?? $_POST['address2'] ?? 'unknown',
    'city' => $input['city'] ?? $_POST['city'] ?? 'unknown',
    'zip' => $input['zip'] ?? $_POST['zip'] ?? 'unknown',
    'items' => $input['items'] ?? $_POST['items'] ?? 'unknown',
    'totalQuantity' => $input['totalQuantity'] ?? $_POST['totalQuantity'] ?? 'unknown',
    'totalPrice' => $input['totalPrice'] ?? $_POST['totalPrice'] ?? 'unknown',
    'date' => date('D-m-y H:i:s')
];

file_put_contents('orders.json', json_encode($order, JSON_PRETTY_PRINT), FILE_APPEND);

$ordersFile = 'orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$orders[] = $order;
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

echo json_encode([
    'id' => $order['id'],
    'status' => 'succeeded',
    'confirmation_url' => 'success.php?status=success'
]);
<?php
header('Content-Type: application/json');

require_once __DIR__ . '/formValidation.php';
$errors = validateForm($_POST);
if (array_filter($errors)) {
    http_response_code(422);
    echo json_encode(['errors' => $errors]);
    exit;
}

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

$ordersFile = 'orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$orders[] = $order;
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

echo json_encode([
    'id' => $order['id'],
    'status' => 'succeeded',
    'confirmation_url' => 'success.php?status=success&payment_id=' . $order['id']
]);

//php mailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $items = $_POST['items'];
    $totalQuantity = $_POST['totalQuantity'];
    $totalPrice = $_POST['totalPrice'];


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'plushabeststyle@gmail.com';
        $mail->Password = 'здесь должен быть пароль приложения';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('plushabeststyle@gmail.com', 'New order');
        $mail->addAddress('plushabeststyle@gmail.com', 'Recipient Name');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "<h2>New Order</h2>
<p><strong>email:</strong> $email</p>
<p><strong>address:</strong> $address</p>
<p><strong>address2:</strong> $address2</p>
<p><strong>city:</strong> $city</p>
<p><strong>zip:</strong> $zip</p>
    <p>items: $items</p>
    <p>quantity: $totalQuantity</p>
    <p>total price: $totalPrice</p>";

        if ($mail->send()) {
//            header("Location: success.php");
            exit();
        } else {
            echo "Message could not be sent.";
        }
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

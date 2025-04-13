<?php

session_start();

function validateEmail($email) {
    if (empty($email)) {
        return "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return null;
}

function validateAddress($address) {
    if (empty($address)) {
        return "Please enter your address.";
    }
    return null;
}

function validateAddress2($address2) {
    if (empty($address2)) {
        return "Please enter your address.";
    }
    return null;
}

function validateCity($city) {
    if (empty($city)) {
        return "Please enter your city.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $city)) {
        return "City should only contain letters and spaces.";
    }
    return null;
}

function validateZip($zip) {
    if (empty($zip)) {
        return "Please enter your zip.";
    } elseif (!preg_match("/^\d{5}(?:[-\s]\d{4})?$/", $zip)) {
        return "Please enter a valid ZIP code (e.g. 12345 or 12345-6789).";
    }
    return null;
}

function validateForm($data): array {
    $errors = [];
    $errors['email'] = validateEmail($data['email']);
    $errors['address'] = validateAddress($data['address']);
    $errors['address2'] = validateAddress2($data['address2']);
    $errors['city'] = validateCity($data['city']);
    $errors['zip'] = validateZip($data['zip']);
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateForm($_POST);

    if (array_filter($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header('Location: index.html');
        exit;
    }

    require_once 'fakePayment.php';
}
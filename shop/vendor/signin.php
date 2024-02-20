<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}

if ($password === '') {
    $error_fields[] = 'password';
}

if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте правильность полей",
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    $password_hash = $user['password'];
    $isAdmin = $user['is_admin']; // Retrieve the is_admin value from the database

    if (password_verify($password, $password_hash)) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "email" => $user['email'],
            "is_admin" => $isAdmin // Assign the is_admin value to the session
        ];
        $_SESSION['authorized'] = true;
    
        // Get the value of is_admin from the session
        $user_id = $_SESSION['user']['id'];
        $admin = $_SESSION['user']['is_admin'];
    
        $response = [
            "status" => true
        ];
    
        echo json_encode($response);
    } else {
        $response = [
            "status" => false,
            "message" => 'Неверный логин или пароль'
        ];
    
        echo json_encode($response);
    }
} else {
    $response = [
        "status" => false,
        "message" => 'Не верный логин или пароль'
    ];

    echo json_encode($response);
    die();
}

// Get the value of is_admin from the session
$user_id = $_SESSION['user']['id'];
$admin = $_SESSION['user']['is_admin'];
?>

<?php
require_once "functions/functions.php";
require_once "vendor/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    if (!isset($_SESSION["user_id"])) {
        echo "Ошибка: пользователь не авторизован";
        exit();
    }
    
    $product_id = $_POST["product_id"];
    $user_id = $_SESSION['user']['id'];
    $comment = $_POST["comment"];

    // Валидация и обработка комментария, если необходимо

    // Запрос на добавление комментария в базу данных
    $sql_add_comment = "INSERT INTO comments (product_id, user_id, comment)
                        VALUES ($product_id, $user_id, '$comment')";

    if ($connect->query($sql_add_comment) === TRUE) {
        echo "Комментарий успешно добавлен";
        // Перенаправление обратно на страницу продукта
        header("Location: detail.php?id=$product_id");
        exit();
    } else {
        echo "Ошибка при добавлении комментария: " . $connect->error;
    }
}

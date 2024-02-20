<?php
// Подключение к базе данных
require_once "../functions/functions.php";
require_once "../vendor/connect.php";

// Проверка, что запрос является AJAX-запросом
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Получение данных формы
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $phone = $_POST["phone"];

    // Валидация имени
    $nameErr = '';
    if (empty($name)) {
        $nameErr = "Имя обязательно для заполнения";
    } elseif (!preg_match("/^[а-яА-Я\s]+$/u", $name)) {
        $nameErr = "Имя должно содержать только буквы";
    }

    // Валидация номера телефона
    $phoneErr = '';
    if (empty($phone)) {
        $phoneErr = "Номер телефона обязателен для заполнения";
    } elseif (!preg_match("/^\d{10}$/", $phone)) {
        $phoneErr = "Номер телефона должен состоять из 10 цифр";
    }

    // Если нет ошибок валидации, добавляем данные в таблицу
    if (empty($nameErr) && empty($phoneErr)) {
        // Подготовка и выполнение SQL-запроса для вставки данных в таблицу
        $sql = "INSERT INTO helps (name, username, phone) VALUES ('$name', '$surname', '$phone')";
        if (mysqli_query($connect, $sql)) {
            $response = array(
                'success' => true,
                'message' => 'Данные успешно добавлены в таблицу.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'success' => false,
                'message' => 'Ошибка при добавлении данных в таблицу: ' . mysqli_error($connect)
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            'success' => false,
            'nameErr' => $nameErr,
            'phoneErr' => $phoneErr
        );
        echo json_encode($response);
    }

    // Закрытие соединения с базой данных
    mysqli_close($connect);
} else {
    // Если запрос не является AJAX-запросом, перенаправляем на другую страницу или выводим ошибку
    echo "Ошибка: некорректный запрос.";
}

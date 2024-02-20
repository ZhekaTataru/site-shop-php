<?
session_start();
if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
    // Пользователь не авторизован, необходимо перенаправить на страницу авторизации
    header('Location: /login.php');
    exit();
}
// Подключение к базе данных (предполагается, что вы уже импортировали файл connect.php)
require_once "../functions/functions.php";
require_once "../vendor/connect.php";
require($_SERVER['DOCUMENT_ROOT'] . '/blocks/header.php');
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<div class="container">
    <h1>Мои заказы</h1>

    <?php
    // Получение user_id из сессии (предполагается, что пользователь авторизован)
    $user_id = $_SESSION['user']['id'];

    // Запрос для получения заказов пользователя
    $sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";

    // Выполнение запроса
    $result = mysqli_query($connect, $sql);

    // Проверка наличия заказов
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row">';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4">';
            echo '<div class="card mb-4">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Заказ #' . $row['id'] . '</h5>';
            echo '<p class="card-text">Дата создания: ' . $row['created_at'] . '</p>';
            echo '<p class="card-text">Сумма: ' . $row['total_price'] . '</p>';
            // Дополнительные информационные поля
            // ...
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<p>У вас нет заказов.</p>';
    }

    // Освобождение результата запроса
    mysqli_free_result($result);

    // Закрытие соединения с базой данных
    mysqli_close($connect);
    ?>
</div>
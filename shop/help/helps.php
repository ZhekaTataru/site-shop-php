<?php
// Подключение к базе данных

require_once "vendor/connect.php";

// Переменные для хранения значений полей формы
$name = "";
$surname = "";
$phone = "";

// Переменные для хранения сообщений об ошибках
$nameErr = "";
$phoneErr = "";

// Флаг, указывающий, была ли форма отправлена
$formSubmitted = false;

// Обработка отправленной формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $phone = $_POST["phone"];

    // Валидация имени
    if (empty($name)) {
        $nameErr = "Имя обязательно для заполнения";
    } elseif (!preg_match("/^[а-яА-Я\s]+$/u", $name)) {
        $nameErr = "Имя должно содержать только буквы";
    }

    // Валидация номера телефона
    if (empty($phone)) {
        $phoneErr = "Номер телефона обязателен для заполнения";
    } elseif (!preg_match('/^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/', $phone)) {
        $phoneErr = "Неправильный формат телефона";
    }

    // Если нет ошибок валидации, добавляем данные в таблицу
    if (empty($nameErr) && empty($phoneErr)) {
        // Подготовка и выполнение SQL-запроса для вставки данных в таблицу
        $sql = "INSERT INTO helps (name, username, phone) VALUES ('$name', '$surname', '$phone')";
        if (mysqli_query($connect, $sql)) {
            $formSubmitted = true; // Устанавливаем флаг успешной отправки формы
            $name = ""; // Очищаем значение поля "Имя"
            $surname = ""; // Очищаем значение поля "Фамилия"
            $phone = ""; // Очищаем значение поля "Номер телефона"
            echo '<script>alert("Данные успешно отправлены.");</script>'; // Выводим алерт
        } else {
            echo "Ошибка: " . $sql . "<br>" . mysqli_error($connect);
        }
    }
}

// Закрытие соединения с базой данных
mysqli_close($connect);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Форма помощи</title>
    <script>
        function scrollToForm() {
            var form = document.getElementById("help_form");
            form.scrollIntoView();
        }

        window.onload = function() {
            <?php if (!empty($nameErr) || !empty($phoneErr)) : ?>
                scrollToForm();
            <?php endif; ?>
        };
    </script>
</head>

<body>
    <div class="help_block">
        <div class="help_form">
            <div class="title-block-help">
                <div style="width: 55%"><h1 class="title_help">Возникли вопросы? Оставьте заявку и мы с вами свяжемся!</h1></div>
                <div style="height:50px;"><h4 style="padding-top:10px;" class="category_text">Менеджер свяжеться с вами в течении часа.</h4></div>
            </div>
            <form id="help_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group-inline">
                    <div class="form-group-help">
                        <label for="name">Имя:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                        <?php if (!empty($nameErr)) echo '<small class="text-danger">' . $nameErr . '</small>'; ?>
                    </div>

                    <div class="form-group-help">
                        <label for="surname">Фамилия:</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname; ?>">
                    </div>
                </div>
                <div class="form-group-inline">
                    <div class="form-group-help">
                        <label for="phone">Номер телефона:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                        <?php if (!empty($phoneErr)) echo '<small class="text-danger">' . $phoneErr . '</small>'; ?>
                    </div>
                    <div class="form-group-help">
                        <input type="submit" class="btn" value="Отправить" onclick="scrollToForm()">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

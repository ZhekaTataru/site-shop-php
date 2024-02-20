<?php
session_start();
if ($_SESSION['user']) {
    header('Location: profile.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!-- Форма регистрации -->

    <form>
        <label>ФИО</label>
        <input type="text" name="full_name" placeholder="Введите свое полное имя">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Почта</label>
        <input type="email" name="email" placeholder="Введите адрес своей почты">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <button type="submit" class="register-btn">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="/login.php">авторизируйтесь</a>!
        </p>
        <p class="msg none">Lorem ipsum.</p>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $('.register-btn').click(function(e) {
            e.preventDefault();

            $(`input`).removeClass('error');

            let login = $('input[name="login"]').val(),
                password = $('input[name="password"]').val(),
                full_name = $('input[name="full_name"]').val(),
                email = $('input[name="email"]').val(),
                password_confirm = $('input[name="password_confirm"]').val();

            let formData = new FormData();
            formData.append('login', login);
            formData.append('password', password);
            formData.append('password_confirm', password_confirm);
            formData.append('full_name', full_name);
            formData.append('email', email);


            $.ajax({
                url: 'vendor/signup.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                success(data) {

                    if (data.status) {
                        document.location.href = '/login.php';
                    } else {

                        if (data.type === 1) {
                            data.fields.forEach(function(field) {
                                $(`input[name="${field}"]`).addClass('error');
                            });
                        }

                        $('.msg').removeClass('none').text(data.message);

                    }

                }
            });

        });
    </script>
</body>

</html>
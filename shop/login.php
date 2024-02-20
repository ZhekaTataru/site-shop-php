<?php
session_start();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!-- Форма авторизации -->

    <form>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <button type="submit" class="login-btn">Войти</button>
        <a style="text-align: center;"  href="/index.php">продолжить без авторизации</a>
        <p>
            У вас нет аккаунта? - <a href="/register.php">зарегистрируйтесь</a>!
        </p>
        
        <p class="msg none">Lorem ipsum dolor sit amet.</p>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        /*
    Авторизация
 */

        $('.login-btn').click(function(e) {
            e.preventDefault();

            $(`input`).removeClass('error');

            let login = $('input[name="login"]').val(),
                password = $('input[name="password"]').val();

            $.ajax({
                url: 'vendor/signin.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    login: login,
                    password: password
                },
                success(data) {

                    if (data.status) {
                        document.location.href = '/index.php';
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
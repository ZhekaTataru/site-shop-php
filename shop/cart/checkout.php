<?php

session_start();

if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
    // User is not authorized, redirect to login page
    header('Location: /login.php');
    exit();
}

require_once "../functions/functions.php";
require_once "../vendor/connect.php";
require($_SERVER['DOCUMENT_ROOT'] . '/blocks/header.php');
$totalPrice = calculateTotalPrice();
$cartSum = sumCartProducts();
$ukraine_cities = array(
    "Винница",
    "Днепр",
    "Донецк",
    "Житомир",
    "Запорожье",
    "Ивано-Франковск",
    "Киев",
    "Кропивницкий",
    "Кривой Рог",
    "Луганск",
    "Луцк",
    "Львов",
    "Николаев",
    "Одесса",
    "Полтава",
    "Ровно",
    "Сумы",
    "Тернополь",
    "Ужгород",
    "Харьков",
    "Херсон",
    "Хмельницкий",
    "Черкассы",
    "Чернигов",
    "Черновцы"
);

// Check if the cart is empty
if (count($_SESSION['cart']) == 0) {
    header('Location: /cart.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $post_index = $_POST['post_index'];
    $errors = array();
    $err = array();

    // Validate the name field
    if (empty($name)) {
        $errors[] = "Имя обязательно для заполнения";
        $err['name'] = '<small class="text-danger">Имя обязательно для заполнения</small>';
    } elseif (!preg_match("/^[а-яА-Я тцушщхъфырэчсью]+$/i", $name)) {
        $errors[] = "Имя должно содержать только буквы";
        $err['name'] = '<small class="text-danger">Здесь только кириллица</small>';
    }
    // Validate the email field
    if (empty($email)) {
        $errors[] = "Email обязателен для заполнения";
        $err['email'] = '<small class="text-danger">Email обязателен для заполнения</small>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Неправильный формат email";
        $err['email'] = '<small class="text-danger">Неправильный формат email</small>';
    }

    // Validate the phone field
    if (empty($phone)) {
        $errors[] = "Телефон обязателен для заполнения";
        $err['phone'] = '<small class="text-danger">Телефон обязателен для заполнения</small>';
    } elseif (!preg_match('/^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/', $phone)) {
        $errors[] = "Неправильный формат телефона";
        $err['phone'] = '<small class="text-danger">Неправильный формат телефона</small>';
    }

    // Validate the city field
    if (empty($city)) {
        $errors[] = "Город обязателен для заполнения";
        $err['city'] = '<small class="text-danger">Город обязателен для заполнения</small>';
    } elseif (!in_array($city, $ukraine_cities)) {
        $errors[] = "Неправильный город";
        $err['city'] = '<small class="text-danger">Неправильный город</small>';
    }

    // Validate the post index field
    if (empty($post_index)) {
        $err['post_index'] = '<small class="text-danger">Индекс обязателен для заполнения</small>';
    } elseif (!empty($post_index) && !preg_match("/^[0-9]{5}$/", $post_index)) {
        $errors[] = "Неправильный почтовый индекс";
        $err['post_index'] = '<small class="text-danger">Неправильный почтовый индекс</small>';
    }


    if (count($errors) == 0) {
        // Save the order to the database here
        $user_id = $_SESSION['user']['id'];
        $products = json_encode($_SESSION['cart']); // assuming $_SESSION['cart'] is an array of products
        $total_price = $totalPrice;
        $address = ($post_index ? $post_index . ', ' : '') . $city;

        // Save the order to the database here
        if (!$connect) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare the product data as a string
        $productData = '';
        foreach ($_SESSION['cart'] as $product) {
            $productData .= $product['name'] . ':' . $product['quantity'] . ', ';
        }
        $productData = rtrim($productData, ', ');

        // Prepare the SQL statement
        $sql = "INSERT INTO orders (user_id, products, total_price, address, name, email, phone, city, post_index) VALUES ('$user_id', '$productData', '$total_price', '$address','$name','$email','$phone','$city','$post_index')";

        // Execute the SQL statement
        if (mysqli_query($connect, $sql)) {
            // Set the flag for successful form submission
            $_SESSION['order_submitted'] = true;
            clearCart();
            // Redirect to the order confirmation page
            header('Location: /index.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
    }
}

?>
<div class="content">
    <div class="title-order">
        <h2 style="font-weight: bold;">Оформление заказа</h2>
    </div>
    <div class="content_4">
        <div class="order">
            <h4>Данные для заказа</h4>
            <form class="order-form" method="post" action="">

                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">
                    <?php if (isset($err['name'])) echo $err['name'] ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                    <?php if (isset($err['email'])) echo '<small class="text-danger">' . $err['email'] . '</small>'; ?>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
                    <?php if (isset($err['phone'])) echo '<small class="text-danger">' . $err['phone'] . '</small>'; ?>
                </div>
                <div class="form-group">
                    <label for="city">Город:</label>
                    <select class="form-control" id="city" name="city">
                        <option value="">Выберите город</option>
                        <?php foreach ($ukraine_cities as $city_name) : ?>
                            <option value="<?php echo $city_name ?>" <?php echo isset($_POST['city']) && $_POST['city'] == $city_name ? 'selected' : '' ?>><?php echo $city_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($err['city'])) echo '<small class="text-danger">' . $err['city'] . '</small>'; ?>
                </div>
                <div class="form-group">
                    <label for="post_index">Почтовый индекс:</label>
                    <input type="text" class="form-control" id="post_index" name="post_index" value="<?php echo isset($_POST['post_index']) ? $_POST['post_index'] : '' ?>">
                    <?php if (isset($err['post_index'])) echo '<small class="text-danger">' . $err['post_index'] . '</small>'; ?>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        <div>
            <h4>Товары в корзине</h4>
            <? echo $user_id ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Количество</th>
                        <th style="width: 80px;">Цена</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $product) { ?>
                        <tr class="product-item">
                            <td class="product-info">
                                <span class="product-name"><?php echo $product['name']; ?></span>
                            </td>
                            <td class="product-quantity"><?php echo $product['quantity']; ?></td>
                            <td class="product-price"><?php echo $product['price'] * $product['quantity']; ?> ₴</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" class="total-price-title">Итого:</td>
                        <td class="price-amount"><?php echo $totalPrice; ?> ₴</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        
    </div>
    <? require($_SERVER['DOCUMENT_ROOT'] . '/blocks/foother.php'); ?>
</div>
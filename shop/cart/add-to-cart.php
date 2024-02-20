<?php
session_start();

if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
  // Пользователь не авторизован, необходимо перенаправить на страницу авторизации
  header('Location: ./login.php');
  exit();
}

// Get the product details
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];

// Add the product to the cart
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

$cart = &$_SESSION['cart'];

if (isset($cart[$id])) {
  $cart[$id]['quantity']++;
} else {
  $cart[$id] = array(
    'name' => $name,
    'price' => $price,
    'image' => $image,
    'quantity' => 1,
    'session_id' => session_id() // Добавление идентификатора сессии
  );
}

// Return the total number of items in the cart for the current user
$count = 0;
foreach ($cart as $item) {
  if ($item['session_id'] === session_id()) { // Условие для проверки идентификатора сессии
    $count += $item['quantity'];
  }
}

// Return the count as JSON
echo json_encode(array('count' => $count));

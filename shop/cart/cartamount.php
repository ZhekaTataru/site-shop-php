<?php
// Обработка данных от пользователя
$id = isset($_POST['id']) ? $_POST['id'] : null;
$quantity = isset($_POST['col_tov']) ? $_POST['col_tov'] : null;

// Если переданы корректные данные, обновляем количество товара в корзине
if ($id !== null && $quantity !== null) {
    $_SESSION['cart'][$id]['quantity'] = $quantity;
}

$count = empty($_SESSION['cart']) ? 0 : count($_SESSION['cart']);

// Отправляем клиенту количество товаров после обновления
echo $count;

?>
<?php
session_start();

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$id])) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$id]); // удаляем товар из корзины
            return;
        }
        $_SESSION['cart'][$id]['quantity'] = $quantity;
        // вычисляем новую стоимость товара и общую стоимость товаров в корзине
        $price = $_SESSION['cart'][$id]['price'];
        $totalPrice = $price * $quantity;
        $_SESSION['cart'][$id]['total_price'] = $totalPrice;
        $totalCartPrice = array_sum(array_column($_SESSION['cart'], 'total_price'));

        // отправляем клиенту обновленную информацию о корзине
        $response = [
            'cart_count' => count($_SESSION['cart']),
            'total_price' => $totalCartPrice,
        ];
        echo json_encode($response);
    }
}

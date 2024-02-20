<?php
session_start();

if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
    // Пользователь не авторизован, необходимо перенаправить на страницу авторизации
    header('Location: /login.php');
    exit();
}

require_once "../functions/functions.php";
require($_SERVER['DOCUMENT_ROOT'] . '/blocks/header.php');
$totalPrice = calculateTotalPrice();
$cartSum = sumCartProducts();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // если нет, создаем пустой массив
}

// получаем данные о товаре из запроса
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['image'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // добавляем товар в корзину
    if (isset($_SESSION['cart'][$id])) {
        // if the product already exists in the cart, increase the quantity
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        // if the product doesn't exist in the cart, add it
        $_SESSION['cart'][$id] = array(
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => $_POST['quantity'] // the quantity of the product
        );
    }


    // возвращаем количество товаров в корзине
    echo count($_SESSION['cart']);
}
?>
<div class="content">
    <div class="content_3">
        <?php if (count($_SESSION['cart']) == 0) : ?>
            <h2>Ваша корзина пуста</h2>
        <?php else : ?>
            <table class="cart-table">
                <tr>
                    <th>Фото</th>
                    <th>Название</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $id => $product) : ?>
                    <tr id="<?= $id ?>" class="cart-item">
                        <td><a href="/detail.php?id=<?= $id ?>"><img src="/img/<?= $product['image'] ?>.webp" alt="фото товара" width="50" height="50"></a></td>
                        <td><a href="/detail.php?id=<?= $id ?>" class="name_tovar"><?= $product['name'] ?></a></td>
                        <td>
                            <div class="quantity-container">
                                <button class="decrement-btn" id="<?= $id ?>">-</button>
                                <input type="number" class="count-product" id="<?= $id ?>" value="<?= $product['quantity'] ?>">
                                <button class="increment-btn" id="<?= $id ?>">+</button>
                            </div>
                        </td>
                        <td class="price" id="<?= $id ?>"><?= sumProduct($id) ?> ₴</td>
                        <td><button class="btn-del" id="<?= $id ?>">Удалить</button></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="total-price" colspan="3">Общая сумма заказа: <?= $totalPrice ?> ₴ </td>
                    <td class="total-price"><a class="continue-shopping-btn" href="/index.php">Продолжить покупки</a></td>

                    <td class="total-price">
                        <a href="/cart/checkout.php">
                            <button class="btn-order">Оформить заказ</button>
                        </a>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

    </div>


    <? require($_SERVER['DOCUMENT_ROOT'] . '/blocks/foother.php'); ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    //изменение количества
    $('.count-product').change(function() { //изменение содержимого инпута     
        var col = $(this).val(); //получаем количество
        if (col < 1) {
            col = 1;
            $(this).val(1);
        } //если ввели меньше 1 установим 1
        var id = $(this).attr('id'); //получаем id товара
        $.ajax({ //аякс-запрос
            type: "POST", //метод
            url: 'cartamount.php', //куда передаем
            data: {
                col_tov: col,
                id: id
            }, //данные
            success: function(totalPrice) { //получаем результат
                $('.total-price').html('Общая сумма заказа: ' + totalPrice + ' ₴');
            }
        });
    });

    //удаление товара
    $('.btn-del').click(function() { //клик на кнопку     
        var id = $(this).attr('id'); //получаем id товара
        $.ajax({ //аякс-запрос
            type: "POST", //метод
            url: 'cartdel.php', //куда передаем
            data: {
                id: id
            }, //данные
            success: function(data) { //получаем результат
                //тут можно пересчитать сумму
                $('tr#' + id).css('display', 'none'); //скрываем строку таблицы
                location.reload();
            }
        });
    });
    // уменьшение количества
    $('.decrement-btn').click(function() {
        var input = $(this).siblings('.count-product');
        var col = parseInt(input.val()) - 1;
        if (col < 1) {
            col = 1;
        }
        input.val(col);
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "update_quantity.php",
            data: {
                id: id,
                quantity: col
            },
            success: function(data) {
                // обновляем итоговую стоимость товаров
                var totalPrice = data.total_price;
                $('.total-price').text(totalPrice);

                // обновляем количество товаров в корзине
                var cartCount = data.cart_count;
                $('.cart-count').text(cartCount);
                location.reload();

            }
        });
    });


    // увеличение количества
    $('.increment-btn').click(function() {
        var input = $(this).siblings('.count-product');
        var col = parseInt(input.val()) + 1;
        input.val(col);
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "update_quantity.php",
            data: {
                id: id,
                quantity: col
            },
            success: function(data) {
                // обновляем итоговую стоимость товаров
                var totalPrice = data.total_price;
                $('.total-price').text(totalPrice);

                // обновляем количество товаров в корзине
                var cartCount = data.cart_count;
                $('.cart-count').text(cartCount);
                location.reload();
            }
        });
    });
</script>
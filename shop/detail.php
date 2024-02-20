<?php
require_once "functions/functions.php";
require_once "vendor/connect.php";
$goods = $_GET["id"];
$tovar_rec = getRecommendedTovar();
$tovar_id = get_stuff_by_id($goods);
$category = $tovar_id["category"];
$related_products = get_stuff_by_category($category, $goods); // Get up to 5 products from the same category


?>
<?php require "blocks/header.php" ?>
<div class="content">
    <div class="content_2">
        <div class="detail_img">
            <img src="img/<?php echo $tovar_id["img"]; ?>.webp" alt="" class="detail_img_tovar">
        </div>
        <div class="detail_text">
            <div class="detail_name">
                <h4 class="detail_name_tovar"><?php echo $tovar_id["title"]; ?></h4>
                <p><a style="color: rgb(137, 196, 244); text-decoration:underline" href="/">
                        <a href="/index.php?category=<?php echo $tovar_id['category']; ?>">
                            <h5 style="font-size: 20px; margin-top: 25px; color: grey;"><?php echo $tovar_id["category"]; ?></h5>
                        </a>
            </div>
            <div class="detail_price">
                <h5 class="price_detail"><?php echo $tovar_id["price"]; ?> ₴</h5>
            </div>
            <div class="detail_number">
                <label>
                    
                </label>
            </div>
            <div class="detail_button">
                <button class="custom-btn btn-7" data-id="<?php echo $tovar_id['id']; ?>" data-name="<?php echo $tovar_id['title']; ?>" data-price="<?php echo $tovar_id['price']; ?>" data-image="<?php echo $tovar_id['img']; ?>">В корзину</button>
            </div>
            <div class="detail_info">
                <h4 class="info_text">
                    <p><?php echo $tovar_id["text_tovar"]; ?></p>
                </h4>
            </div>
        </div>
    </div>
    <div class="comments-section">
        <h2 style="font-weight: bold; font-size: 25px">Комментарии </h2> 
        <button id="add-comment-btn" class="add-comment-btn" onclick="toggleCommentForm()">Оставить комментарий</button>
        <div class="comments-container">
            <?php
            // Запрос на получение комментариев для текущего продукта
            $sql_get_comments = "SELECT c.comment, u.full_name, c.created_at
                             FROM comments c
                             INNER JOIN users u ON c.user_id = u.id
                             WHERE c.product_id = $goods ORDER BY c.created_at DESC";

            $result = mysqli_query($connect, $sql_get_comments);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="comment">';
                        echo '<div class="comment-header">';
                        echo '<p class="username">' . $row['full_name'] . '</p>';
                        echo '<p class="timestamp">' . date("j F Y", strtotime($row['created_at'])) . '</p>';
                        echo '</div>';
                        echo '<p class="comment-text">' . $row['comment'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "Нет комментариев для этого продукта";
                }
            } else {

                echo "Ошибка при получении комментариев: " . mysqli_error($connect);
            }
            ?>
        </div>
        
        <form id="comment-form" class="comment-form" action="add_comment.php" method="POST" style="display: none;">
            <input type="hidden" name="product_id" value="<?php echo $goods; ?>">
            <textarea name="comment" placeholder="Оставьте комментарий" rows="4" required></textarea>
            <button class="submit-btn" type="submit">Отправить комментарий</button>
        </form>
    </div>
    <div class="related-products">
        <h2 style="font-weight: bold; text-shadow: 2px 4px 3px rgba(0,0,0,0.3);">Похожие продукты</h2>
        <div class="product-list">
            <?php
            shuffle($related_products); // перемешиваем массив с товарами
            $count = 0; // счетчик товаров
            foreach ($related_products as $product) :
                if ($count < 4) : // выводим только первые 5 товаров
            ?>
                    <div class="product-item">
                        <div class="img">
                            <a href="/detail.php?id=<?php echo $product["id"]; ?>">
                                <img src="img/<?php echo $product["img"]; ?>.webp" alt="">
                            </a>
                        </div>
                        <div class="text">
                            <div class="text_name_">
                                <a href="/detail.php?id=<?php echo $product["id"]; ?>" class="name_tovar">
                                    <h4 class="name_tovar"><?php echo $product["title"]; ?></h4>
                                </a>
                            </div>
                            <div class="text_price">
                                <p class="price"><?php echo $product['price']; ?> ₴</p>
                            </div>
                        </div>

                    </div>
            <?php
                    $count++;
                else :
                    break; // останавливаем цикл после вывода первых 5 товаров
                endif;
            endforeach;
            ?>
        </div>
        <div class="mom">
            <h1 style="font-weight: bold; text-shadow: 2px 4px 3px rgba(0,0,0,0.3); text-align: center;">Популярные товары</h1>
            <div class="slider">
                <?php foreach ($tovar_rec as $item) : ?>
                    <div class="tovar-rec">
                        <div class="img-rec">
                            <a href="/detail.php?id=<?php echo $item["id"]; ?>">
                                <img src="img/<?php echo $item["img"]; ?>.webp" alt="">
                            </a>
                        </div>
                        <div class="text-rec">
                            <div class="text_name">
                                <a href="/detail.php?id=<?php echo $item["id"]; ?>" class="name_tovar">
                                    <h4 class="name_tovar"><?php echo $item["title"]; ?></h4>
                                </a>
                            </div>
                            <div class="text_category">
                                <h4 class="category_text">Категория: <?php echo $item["category"]; ?></h4>
                            </div>
                            <div class="text_price">
                                <h5 class="price"><?php echo $item["price"]; ?> ₴</h5>
                            </div>
                        </div>
                        <div class="button_wrapper-rec">
                            <button class="buy-button" data-id="<?php echo $item['id']; ?>" data-name="<?php echo $item['title']; ?>" data-price="<?php echo $item['price']; ?>" data-image="<?php echo $item['img']; ?>">В корзину</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php require "blocks/foother.php" ?>
</div>


<script>
    $('.slider').slick({
        slidesToScroll: 1,
        autoplay: true, // включаем автоматическую прокрутку
        autoplaySpeed: 2000
    });
    $('.buy-button, .custom-btn.btn-7').click(function() {
        <?php if (!isset($_SESSION['user'])) { ?>
            alert("Необходимо авторизоваться для добавления товара в корзину");
            window.location.href = '/login.php'; // перенаправление на страницу входа
            return;
        <?php } ?>

        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var image = $(this).data('image');
        $.ajax({
            type: "POST",
            url: 'cart/add-to-cart.php',
            data: {
                id: id,
                name: name,
                price: price,
                image: image
            },
            success: function(data) {
                console.log('Товар добавлен в корзину:', {
                    id,
                    name,
                    price,
                    image
                });
                var count = JSON.parse(data).count;
                $('.btn-cart').text(count);
                window.location.href = '/cart/cart.php'; // перенаправление на страницу корзины
            }
        });
    });

    function toggleCommentForm() {
        var form = document.getElementById("comment-form");
        var button = document.getElementById("add-comment-btn");

        <?php if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) { ?>
            alert("Пожалуйста, авторизуйтесь для того, чтобы оставить комментарий.");
            window.location.replace("login.php");
        <?php } else { ?>
            if (form.style.display === "none") {
                form.style.display = "block";
                button.innerHTML = "Скрыть форму";
            } else {
                form.style.display = "none";
                button.innerHTML = "Оставить комментарий";
            }
        <?php } ?>
    }
</script>
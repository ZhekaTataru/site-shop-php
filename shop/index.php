<?php
require_once "functions/functions.php";
$tovar = getTovar();
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$count = 9;

// Получить список уникальных категорий
$categories = array_unique(array_column($tovar, 'category'));

// Определяем тип сортировки
$sort_type = isset($_GET['sort']) ? $_GET['sort'] : 'none';

// Определяем категорию товара
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Фильтруем товары в соответствии с выбранной категорией
if ($category) {
    $tovar = array_filter($tovar, function ($t) use ($category) {
        return $t['category'] == $category;
    });
}

// Сортируем товары в соответствии с выбранной ценой и типом сортировки
$sort_price = isset($_GET['sort_price']) ? $_GET['sort_price'] : 'none';
if ($sort_price == 'asc') {
    usort($tovar, function ($a, $b) {
        return $a['price'] - $b['price'];
    });
} else if ($sort_price == 'desc') {
    usort($tovar, function ($a, $b) {
        return $b['price'] - $a['price'];
    });
}
$page_count = ceil(count($tovar) / $count);

?>

<?php require "recomend.php" ?>

<div class="content">

    <div class="sort-wrapper">
        <form action="/" method="GET">
            <label class="sort-label" for="sort_price">Сортировать по цене:</label>
            <select class="sort-select" name="sort_price" id="sort_price">
                <option value="none">Выберите опцию</option>
                <option value="asc" <?php if (isset($_GET['sort_price']) && $_GET['sort_price'] == 'asc') {
                                        echo 'selected';
                                    } ?>>По возрастанию</option>
                <option value="desc" <?php if (isset($_GET['sort_price']) && $_GET['sort_price'] == 'desc') {
                                            echo 'selected';
                                        } ?>>По убыванию</option>
            </select>
            <?php if ($category) : ?>
                <input type="hidden" name="category" value="<?php echo $category; ?>">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
            <?php endif; ?>
            <button class="sort-btn" type="submit">Отсортировать</button>
        </form>
    </div>
    <div class="content_2">

        <div class="filters">
            <h3 class="filters-title">Фильтры</h3>
            <ul class="filters-list">
                <li><a href="/index.php" class="filters-item <?php if (!isset($_GET['category'])) {
                                                                    echo 'active';
                                                                } ?>">Все товары</a></li>
                <?php foreach ($categories as $c) : ?>
                    <li><a href="/index.php?category=<?php echo $c; ?>" class="filters-item <?php if (isset($_GET['category']) && $_GET['category'] == $c) {
                                                                                                echo 'active';
                                                                                            } ?>"><?php echo $c; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="katalog">

            <?php foreach (array_slice($tovar, $page * $count, $count) as $t) : ?>
                <div class="tovar">
                    <div class="img">
                        <a href="/detail.php?id=<?php echo $t["id"]; ?>">
                            <img src="img/<?php echo $t["img"]; ?>.webp" alt="">
                        </a>
                    </div>
                    <div class="text">
                        <div class="text_name">
                            <a href="/detail.php?id=<?php echo $t["id"]; ?>" class="name_tovar">
                                <h4 class="name_tovar"><?php echo $t["title"]; ?></h4>
                            </a>
                        </div>
                        <div class="text_category">
                            <h4 class="category_text">Категория: <?php echo $t["category"]; ?></h4>
                        </div>
                        <div class="text_price">
                            <h5 class="price"><?php echo $t["price"]; ?> ₴</h5>
                        </div>
                    </div>
                    <div class="button_wrapper">
                        <button class="buy-button" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['title']; ?>" data-price="<?php echo $t['price']; ?>" data-image="<?php echo $t['img']; ?>">В корзину</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (count($tovar) > $count) : ?>
                <nav class="page_list" aria-label="...">
                    <ul class="pagination pagination-lg">
                        <?php for ($p = 0; $p < $page_count; $p++) : ?>
                            <li class="page-item <?php echo $p == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $p; ?>&amp;<?php if (isset($category)) echo 'category=' . $category . '&amp;'; ?>sort_price=<?php echo $sort_price; ?>"><?php echo $p + 1; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require "help/helps.php" ?>

<?php require "blocks/foother.php" ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
session_start();

if (isset($_SESSION['order_submitted']) && $_SESSION['order_submitted'] === true) {
    // Clear the flag
    $_SESSION['order_submitted'] = false;
?>
    <script>
        window.onload = function() {
            alert("Заказ успешно отправлен");
        };
    </script>
<?php
}
?>
<script>
    $('.buy-button').click(function() {
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
</script>
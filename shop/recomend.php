  <?php
  require_once "functions/functions.php";
  $tovar_rec = getRecommendedTovar();
  ?>
  <?php require "blocks/header.php" ?>
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
  <script>
    $('.slider').slick({
      slidesToScroll: 1,
      autoplay: true, // включаем автоматическую прокрутку
      autoplaySpeed: 2000
    });
  </script>

  <!-- $tovar = getRecommendedTovar();
    foreach ($tovar as $item) {-->
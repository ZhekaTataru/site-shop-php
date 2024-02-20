<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
  <link rel="stylesheet" href="/css/style_slick.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/js/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="/js/slick/slick-theme.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">
      <img class="img_logo" src="../img/free-icon-cup-5500167.png" alt="">
    </a>
    <a class="navbar-brand" href="/">
      Shop
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php if (isset($_SESSION['user'])) { ?>
        <ul class="navbar-nav ml-auto">
          <div class="user-border">
            <li class="nav-item">
              <i class='bx bx-user-circle'></i>
            </li>
            <li class="nav-item">
              <span class="user"><?php echo $_SESSION['user']['full_name']; ?></span>
            </li>
          </div>
          <?php if ($_SESSION['user']['is_admin']==1) { ?> <!-- Check if the user is an admin -->
            <li class="nav-item">
              <a class="nav-link" href="/grids/grid.php">Админ-панель</a>
            </li>
          <?php } ?>
          <div style="padding: 2px">
            <li class="nav-item">
              <a class="btn-logout" href="/vendor/logout.php"><i class='bx bx-log-out bx-rotate-180'></i></a>
            </li>
          </div>

        </ul>
      <?php } else { ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/register.php">РЕГИСТРАЦИЯ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login.php">ВОЙТИ</a>
          </li>
        </ul>
      <?php } ?>
      <div class="cart-container">
        <a class="btn-lg" href="/cart/my_orders.php">
          <i class='bx bx-list-check'></i>
        </a>
        <a class="btn-lg" href="/cart/cart.php">
          <i class='bx bxs-cart-alt'></i>
          <?php
          session_start();
          if (isset($_SESSION['user'])) {
            echo '<span class="btn-cart">' . sumCartProducts() . '</span>';
          }
          ?>
        </a>
      </div>
    </div>


  </nav>
  <a href="#" class="scroll-to-top-btn"><i class='bx bxs-up-arrow-alt'></i></a>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="/js\slick\slick.min.js"></script>
</body>

<script>
  $(document).ready(function() {
    var scrollButton = $('.scroll-to-top-btn');

    $(window).scroll(function() {
      if ($(this).scrollTop() > 200) {
        scrollButton.fadeIn();
      } else {
        scrollButton.fadeOut();
      }
    });

    scrollButton.click(function() {
      $('html, body').animate({
        scrollTop: 0
      }, 1000);
      return false;
    });
  });
</script>
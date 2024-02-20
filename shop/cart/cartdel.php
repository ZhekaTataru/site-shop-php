<?php
require_once "../functions/functions.php";
$id = $_POST['id'];//получаем id
session_start(); //стартуем сессию
$temp = $_SESSION['cart']; //переносим сессию во временную переменную
   if ($temp){
       unset ($temp[$id]);//удаляем запись
      }
$_SESSION['cart'] = $temp; //сохраняем сессию
?>
<script>
    updateCartCount(null, <?= $count ?>);
</script>
<?php
require_once "../functions/functions.php";
session_start();
unset($_SESSION['user']);
$_SESSION['authorized'] = false;
clearCart();
header('Location: ../login.php');
<?php
//Singleton;
class Database
{
    private static $instance;
    private $mysqli;

    private function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "", "shop");
        $this->mysqli->query("SET NAMES 'utf-8'");
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }
}
///
function updateCartCount() {
    ?>
    <script>
        $.ajax({
            type: "POST",
            url: 'cart/cartamount.php',
            data: {
                action: 'get_cart_count'
            },
            success: function(count) {
                // Обновляем количество товаров на странице
                $('.cart-count').text(count);
            }
        });
    </script>
    <?php
}


function closeDB()
{
   
}

function getTovar()
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $result = $mysqli->query("SELECT * FROM products ORDER BY id DESC");

    return resultToArray($result);
}

function getRecommendedTovar()
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $result = $mysqli->query("SELECT * FROM products WHERE recommended = 1 ORDER BY id DESC");

    return resultToArray($result);
}

function get_stuff_by_id($goods_id)
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $result = $mysqli->query("SELECT * FROM products where id=$goods_id");

    $r1 = mysqli_fetch_assoc($result);

    return $r1;
}

function get_stuff_by_category($category, $id)
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $result = $mysqli->query("SELECT * FROM products WHERE category = '$category' AND id != $id ORDER BY id DESC");

    return resultToArray($result);
}

function resultToArray($result)
{
    $array = array();
    while (($row = $result->fetch_assoc()) !== null) {
        $array[] = $row;
    }
    return $array;
}

/*cart */
function sumProduct($id)
{
    $totalPriceProduct = 0;
    $product = $_SESSION['cart'][$id];
    $totalPriceProduct = $product['quantity'] * $product['price'];
    return $totalPriceProduct;
}

function sumCartProducts()
{
    $quantity = 0;
    foreach ($_SESSION['cart'] as $id => $product) {
        $quantity += $product['quantity'];
    }
    return $quantity;
}

function calculateTotalPrice()
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $id => $product) {
        $totalPrice += $product['quantity'] * $product['price'];
    }
    return $totalPrice;
}

function addToCart($product_name, $quantity, $price)
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $product_name = mysqli_real_escape_string($mysqli, $product_name);
    $quantity = intval($quantity);
    $price = floatval($price);
    $result = $mysqli->query("SELECT * FROM cart WHERE product_name = '$product_name'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantity += $row['quantity'];
        $mysqli->query("UPDATE cart SET quantity = '$quantity' WHERE id = " . $row['id']);
    } else {
        $mysqli->query("INSERT INTO cart (product_name, quantity, price) VALUES ('$product_name', '$quantity', '$price')");
    }

    return true; // or false if the product could not be added
}

function clearCart()
{
    $_SESSION['cart'] = array();
}

function getTotalCartPrice()
{
    $db = Database::getInstance();
    $mysqli = $db->getMysqli();

    $result = $mysqli->query("SELECT SUM(quantity * price) as total_price FROM cart");
    $row = $result->fetch_assoc();

    return $row['total_price'];
}

function clear_data($val)
{
    $val = trim($val);
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}
?>

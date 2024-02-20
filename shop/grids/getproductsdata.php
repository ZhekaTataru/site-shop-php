<?php
include('../vendor/connect.php');

$sql = "SELECT * FROM products";
$result = mysqli_query($connect, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['id'],
            'img' => $row['img'],
            'title' => $row['title'],
            'category' => $row['category'],
            'text_tovar' => $row['text_tovar'],
            'price' => $row['price'],
            'recommended' => $row['recommended']
        );
    }
}

mysqli_close($connect);

header('Content-Type: application/json');

echo json_encode($data);
?>

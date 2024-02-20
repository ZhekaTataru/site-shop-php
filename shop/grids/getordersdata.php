<?php

include('../vendor/connect.php');

$sql = "SELECT * FROM orders";
$result = mysqli_query($connect, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'user_id' => $row['user_id'],
            'products' => $row['products'],
            'total_price' => $row['total_price'],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'city' => $row['city'],
            'post_index' => $row['post_index'],
            'created_at' => $row['created_at'],
            'address' => $row['address'],
            'id' => $row['id']
        );
    }
}

mysqli_close($connect);

header('Content-Type: application/json');

echo json_encode($data);
?>

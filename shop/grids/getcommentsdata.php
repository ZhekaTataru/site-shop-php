<?php

include('../vendor/connect.php');

$sql = "SELECT * FROM comments";
$result = mysqli_query($connect, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'user_id' => $row['user_id'],
            'comment' => $row['comment'],
            'created_at' => $row['created_at']
        );
    }
}

mysqli_close($connect);

header('Content-Type: application/json');

echo json_encode($data);
?>

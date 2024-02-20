<?php

include('../vendor/connect.php');
$sql = "SELECT * FROM helps";
$result = mysqli_query($connect, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'username' => $row['username'],
            'phone' => $row['phone'],
            'created_at' => $row['created_at']
        );
    }
}

mysqli_close($connect);

header('Content-Type: application/json');

echo json_encode($data);
?>

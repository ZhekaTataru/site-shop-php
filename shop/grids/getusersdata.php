<?php

include('../vendor/connect.php');

$sql = "SELECT * FROM users";
$result = mysqli_query($connect, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'login' => $row['login'],
            'email' => $row['email'],
            'password' => $row['password'],
            'is_admin' => $row['is_admin']
        );
    }
}

mysqli_close($connect);

header('Content-Type: application/json');

echo json_encode($data);
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['user_id'])) {
    $uid = intval($_GET['user_id']);
    $res = $conn->query("SELECT * FROM customers WHERE user_id = $uid");
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "Thiếu user_id"]);
}
?>

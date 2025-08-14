<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['order_id'])) {
    $id = intval($_GET['order_id']);
    $result = $conn->query("SELECT * FROM orders WHERE order_id = $id");
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "Thiếu order_id"]);
}
?>

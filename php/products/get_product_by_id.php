<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['product_id'])) {
    $id = intval($_GET['product_id']);
    $result = $conn->query("SELECT * FROM products WHERE product_id = $id");
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "Thiếu product_id"]);
}
?>

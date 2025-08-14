<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['product_id'])) {
    $id = intval($_GET['product_id']);
    $sql = "DELETE FROM products WHERE product_id = $id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Xoá sản phẩm thành công"]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Thiếu product_id"]);
}
?>

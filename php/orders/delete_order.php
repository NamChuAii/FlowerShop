<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['order_id'])) {
    $id = intval($_GET['order_id']);

    // Xoá các bản ghi phụ thuộc trước
    $conn->query("DELETE FROM order_details WHERE order_id = $id");
    $conn->query("DELETE FROM payments WHERE order_id = $id");
    $conn->query("DELETE FROM shipments WHERE order_id = $id");

    // Sau đó xóa đơn hàng
    $sql = "DELETE FROM orders WHERE order_id = $id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Xoá đơn hàng thành công"]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Thiếu order_id"]);
}
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['customer_id'])) {
    $id = intval($_GET['customer_id']);

    // Nếu có bảng phụ thuộc, xoá trước: orders, reviews...
    $conn->query("DELETE FROM reviews WHERE customer_id = $id");
    $conn->query("DELETE FROM orders WHERE customer_id = $id");

    $sql = "DELETE FROM customers WHERE customer_id = $id";
    if ($conn->query($sql)) {
        echo json_encode(["message" => "Xoá khách hàng thành công"]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Thiếu customer_id"]);
}
?>

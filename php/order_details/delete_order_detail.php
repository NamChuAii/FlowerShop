<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

// 1. Kiểm tra đầu vào
if (!isset($_GET['order_id'], $_GET['product_id'])) {
    echo json_encode(["message" => "Thiếu order_id hoặc product_id"]);
    exit;
}

$order_id = intval($_GET['order_id']);
$product_id = intval($_GET['product_id']);

// 2. Kiểm tra xem dòng có tồn tại không
$check = $conn->query("SELECT * FROM order_details WHERE order_id = $order_id AND product_id = $product_id");
if ($check->num_rows === 0) {
    echo json_encode(["message" => "Chi tiết đơn hàng không tồn tại"]);
    exit;
}

// 3. Xóa nếu tồn tại
$sql = "DELETE FROM order_details WHERE order_id = $order_id AND product_id = $product_id";
if ($conn->query($sql)) {
    if ($conn->affected_rows > 0) {
        echo json_encode(["message" => "Xoá thành công"]);
    } else {
        echo json_encode(["message" => "Không có dòng nào bị xóa"]);
    }
} else {
    echo json_encode(["message" => "Lỗi: " . $conn->error]);
}
?>

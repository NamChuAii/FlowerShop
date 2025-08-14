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

$data = json_decode(file_get_contents("php://input"), true);

// 2. Kiểm tra có dữ liệu cập nhật không
if (!isset($data['quantity']) || !isset($data['unit_price']) || !isset($data['discount'])) {
    echo json_encode(["message" => "Thiếu quantity, unit_price hoặc discount"]);
    exit;
}

$quantity = intval($data['quantity']);
$unit_price = floatval($data['unit_price']);
$discount = floatval($data['discount']);

// 3. Kiểm tra bản ghi có tồn tại không
$check = $conn->query("SELECT * FROM order_details WHERE order_id = $order_id AND product_id = $product_id");
if ($check->num_rows === 0) {
    echo json_encode(["message" => "Không tìm thấy chi tiết đơn hàng cần cập nhật"]);
    exit;
}

// 4. Cập nhật
$sql = "UPDATE order_details SET 
            quantity = $quantity, 
            unit_price = $unit_price,
            discount = $discount 
        WHERE order_id = $order_id AND product_id = $product_id";

if ($conn->query($sql)) {
    if ($conn->affected_rows > 0) {
        echo json_encode(["message" => "Cập nhật thành công"]);
    } else {
        echo json_encode(["message" => "Không có thay đổi nào"]);
    }
} else {
    echo json_encode(["message" => "Lỗi: " . $conn->error]);
}
?>

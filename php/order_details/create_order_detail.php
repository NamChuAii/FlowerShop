<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['order_id'], $data['product_id'], $data['quantity'], $data['unit_price'], $data['discount'])) {
    $order_id = intval($data['order_id']);
    $product_id = intval($data['product_id']);
    $quantity = intval($data['quantity']);
    $unit_price = floatval($data['unit_price']);
    $discount = floatval($data['discount']);
// Kiểm tra order_id có tồn tại không
$check = $conn->query("SELECT order_id FROM orders WHERE order_id = $order_id");
if ($check->num_rows === 0) {
    echo json_encode(["message" => "order_id không tồn tại"]);
    exit;
}

    $sql = "INSERT INTO order_details (order_id, product_id, quantity, unit_price, discount)
            VALUES ($order_id, $product_id, $quantity, $unit_price, $discount)";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Thêm sản phẩm vào đơn hàng thành công"]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Thiếu dữ liệu"]);
}
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['name'], $data['price'], $data['category_id'], $data['supplier_id'], $data['stock_quantity'])) {
    $name = $conn->real_escape_string($data['name']);
    $description = $conn->real_escape_string($data['description'] ?? '');
    $price = floatval($data['price']);
    $category_id = intval($data['category_id']);
    $supplier_id = intval($data['supplier_id']);
    $stock_quantity = intval($data['stock_quantity']);

    $sql = "INSERT INTO products (name, description, price, category_id, supplier_id, stock_quantity)
            VALUES ('$name', '$description', $price, $category_id, $supplier_id, $stock_quantity)";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Thêm sản phẩm thành công", "product_id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
}
?>

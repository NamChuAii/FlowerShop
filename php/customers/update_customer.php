<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

// 1. Kiểm tra tồn tại tham số
if (!isset($_GET['customer_id'])) {
    echo json_encode(["message" => "Thiếu customer_id"]);
    exit;
}

$customer_id = intval($_GET['customer_id']);
$data = json_decode(file_get_contents("php://input"), true);

// 2. Kiểm tra xem customer có tồn tại không
$check = $conn->query("SELECT customer_id FROM customers WHERE customer_id = $customer_id");
if ($check->num_rows === 0) {
    echo json_encode(["message" => "customer_id không tồn tại"]);
    exit;
}

// 3. Chuẩn bị câu lệnh cập nhật
$fields = [];
foreach ($data as $key => $value) {
    $fields[] = "$key='" . $conn->real_escape_string($value) . "'";
}

if (!empty($fields)) {
    $sql = "UPDATE customers SET " . implode(",", $fields) . " WHERE customer_id = $customer_id";
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            echo json_encode(["message" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["message" => "Không có thay đổi nào được thực hiện"]);
        }
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Không có dữ liệu để cập nhật"]);
}
?>

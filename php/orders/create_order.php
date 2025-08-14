<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['customer_id'], $data['employee_id'], $data['order_date'], $data['status'])) {
    $customer_id = intval($data['customer_id']);
    $employee_id = intval($data['employee_id']);
    $order_date = $conn->real_escape_string($data['order_date']);
    $status = $conn->real_escape_string($data['status']);

    // Kiểm tra customer_id
    $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        echo json_encode(["message" => "customer_id không tồn tại"]);
        exit;
    }

    // Tạo đơn hàng
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, employee_id, order_date, status) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $customer_id, $employee_id, $order_date, $status);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        echo json_encode(["message" => "Tạo đơn hàng thành công", "order_id" => $order_id]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Thiếu dữ liệu đầu vào"]);
}
?>
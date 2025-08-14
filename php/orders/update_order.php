<?php
require_once 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $order_id = $_GET['order_id'] ?? '';
    $data = json_decode(file_get_contents("php://input"), true);

    $customer_id = $data['customer_id'] ?? '';
    $employee_id = $data['employee_id'] ?? '';
    $order_date = $data['order_date'] ?? '';
    $status = $data['status'] ?? '';

    if (!$order_id || !$customer_id || !$employee_id || !$order_date || $status === '') {
        http_response_code(400);
        echo json_encode(['message' => 'Thiếu thông tin cần thiết']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE orders SET customer_id = ?, employee_id = ?, order_date = ?, status = ? 
                            WHERE order_id = ?");
    $stmt->bind_param("iisii", $customer_id, $employee_id, $order_date, $status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Cập nhật đơn hàng thành công']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Lỗi cập nhật: ' . $conn->error]);
    }
    $stmt->close();
    $conn->close();
}
?>
<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;
if ($employee_id <= 0) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Thiếu employee_id"]);
  exit;
}

// Kiểm tra ràng buộc: orders đang FK tới employees (không ON DELETE CASCADE)
$chk = $conn->prepare("SELECT 1 FROM orders WHERE employee_id=? LIMIT 1");
$chk->bind_param("i", $employee_id);
$chk->execute();
if ($chk->get_result()->fetch_assoc()) {
  http_response_code(409);
  echo json_encode([
    "status"=>"error",
    "message"=>"Không thể xoá: còn đơn hàng tham chiếu đến nhân viên này"
  ]);
  $chk->close();
  $conn->close();
  exit;
}
$chk->close();

$stmt = $conn->prepare("DELETE FROM employees WHERE employee_id=?");
$stmt->bind_param("i", $employee_id);
if ($stmt->execute()) {
  echo json_encode(["status"=>"success","message"=>"Xoá nhân viên thành công"]);
} else {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Lỗi: ".$conn->error]);
}
$stmt->close();
$conn->close();

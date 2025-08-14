<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;
if ($employee_id <= 0) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Thiếu employee_id"]);
  exit;
}

$stmt = $conn->prepare("SELECT employee_id, full_name, email, position, hire_date FROM employees WHERE employee_id=?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
  echo json_encode($row);
} else {
  http_response_code(404);
  echo json_encode(["status"=>"error","message"=>"Không tìm thấy nhân viên"]);
}
$stmt->close();
$conn->close();

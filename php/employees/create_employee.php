<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

// Nhận JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$full_name = trim($data['full_name'] ?? "");
$email     = trim($data['email'] ?? "");
$position  = trim($data['position'] ?? "");
$hire_date = trim($data['hire_date'] ?? ""); // yyyy-MM-dd

if ($full_name === "" || $email === "" || $position === "" || $hire_date === "") {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Thiếu dữ liệu bắt buộc"]);
  exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Email không hợp lệ"]);
  exit;
}
// kiểm tra định dạng ngày đơn giản (YYYY-MM-DD)
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $hire_date)) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Ngày tuyển dụng không hợp lệ (YYYY-MM-DD)"]);
  exit;
}

$stmt = $conn->prepare("INSERT INTO employees (full_name, email, position, hire_date) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $full_name, $email, $position, $hire_date);
if ($stmt->execute()) {
  echo json_encode(["status"=>"success","message"=>"Tạo nhân viên thành công","employee_id"=>$stmt->insert_id]);
} else {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Lỗi: ".$conn->error]);
}
$stmt->close();
$conn->close();

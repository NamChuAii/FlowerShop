<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;
if ($employee_id <= 0) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Thiếu employee_id"]);
  exit;
}

// Kiểm tra tồn tại
$check = $conn->prepare("SELECT employee_id FROM employees WHERE employee_id=?");
$check->bind_param("i", $employee_id);
$check->execute();
if (!$check->get_result()->fetch_assoc()) {
  http_response_code(404);
  echo json_encode(["status"=>"error","message"=>"Không tìm thấy nhân viên"]);
  $check->close();
  $conn->close();
  exit;
}
$check->close();

// Nhận JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$full_name = isset($data['full_name']) ? trim($data['full_name']) : null;
$email     = isset($data['email']) ? trim($data['email']) : null;
$position  = isset($data['position']) ? trim($data['position']) : null;
$hire_date = isset($data['hire_date']) ? trim($data['hire_date']) : null;

$fields = [];
$params = [];
$types  = "";

if ($full_name !== null) { $fields[]="full_name=?"; $params[]=$full_name; $types.="s"; }
if ($email !== null) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status"=>"error","message"=>"Email không hợp lệ"]);
    exit;
  }
  $fields[]="email=?"; $params[]=$email; $types.="s";
}
if ($position !== null) { $fields[]="position=?"; $params[]=$position; $types.="s"; }
if ($hire_date !== null) {
  if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $hire_date)) {
    http_response_code(400);
    echo json_encode(["status"=>"error","message"=>"Ngày tuyển dụng không hợp lệ (YYYY-MM-DD)"]);
    exit;
  }
  $fields[]="hire_date=?"; $params[]=$hire_date; $types.="s";
}

if (empty($fields)) {
  http_response_code(400);
  echo json_encode(["status"=>"error","message"=>"Không có dữ liệu để cập nhật"]);
  exit;
}

$sql = "UPDATE employees SET ".implode(",",$fields)." WHERE employee_id=?";
$params[] = $employee_id;
$types   .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
  echo json_encode(["status"=>"success","message"=>"Cập nhật nhân viên thành công"]);
} else {
  http_response_code(500);
  echo json_encode(["status"=>"error","message"=>"Lỗi: ".$conn->error]);
}
$stmt->close();
$conn->close();

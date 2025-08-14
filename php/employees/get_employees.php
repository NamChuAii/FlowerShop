<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

$sql = "SELECT employee_id, full_name, email, position, hire_date FROM employees ORDER BY employee_id DESC";
$result = $conn->query($sql);
$data = [];
if ($result) {
  while ($row = $result->fetch_assoc()) { $data[] = $row; }
}
echo json_encode($data);
$conn->close();

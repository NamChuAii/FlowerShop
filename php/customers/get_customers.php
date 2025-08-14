<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>

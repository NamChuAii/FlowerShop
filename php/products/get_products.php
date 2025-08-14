<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$data = [];

$sql = "SELECT p.*, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>

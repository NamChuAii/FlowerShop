<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT * FROM order_details";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$sql = "SELECT od.*, o.customer_id, c.full_name
        FROM order_details od
        JOIN orders o ON od.order_id = o.order_id
        JOIN customers c ON o.customer_id = c.customer_id";
        
$result = $conn->query($sql);
echo json_encode($data);
?>

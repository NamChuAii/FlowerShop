<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT o.order_id, o.customer_id, c.full_name, o.employee_id, o.order_date, o.status,
        COALESCE(SUM(od.quantity * od.unit_price * (1 - IFNULL(od.discount, 0)/100)), 0) AS total_amount
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.customer_id
        LEFT JOIN order_details od ON o.order_id = od.order_id
        GROUP BY o.order_id, o.customer_id, c.full_name, o.employee_id, o.order_date, o.status
        ORDER BY o.order_id DESC";
$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
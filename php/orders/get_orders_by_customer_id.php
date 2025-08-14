<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['customer_id'])) {
    $cid = intval($_GET['customer_id']);
    $result = $conn->query("SELECT * FROM orders WHERE customer_id = $cid");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "Thiếu customer_id"]);
}
?>

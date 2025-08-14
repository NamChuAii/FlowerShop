<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$sql = "SELECT u.user_id, u.full_name FROM users u LEFT JOIN customers c ON u.user_id = c.user_id WHERE c.user_id IS NULL";
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    // Xóa người dùng
    $conn->query("DELETE FROM users WHERE user_id = $user_id");

    echo json_encode(["message" => "Xoá người dùng và toàn bộ dữ liệu liên quan thành công"]);
} else {
    echo json_encode(["message" => "Thiếu user_id"]);
}
?>

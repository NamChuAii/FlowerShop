<?php
include 'connect.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    $sql = "SELECT user_id, username, email, full_name, phone_number, created_at FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["message" => "Không tìm thấy người dùng"]);
    }
} else {
    echo json_encode(["message" => "Thiếu tham số user_id"]);
}

$conn->close();
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    $data = json_decode(file_get_contents("php://input"), true);
    $fields = [];
    foreach ($data as $key => $value) {
        $fields[] = "$key='" . $conn->real_escape_string($value) . "'";
    }
    if (!empty($fields)) {
        $sql = "UPDATE users SET " . implode(",", $fields) . " WHERE user_id = $user_id";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["message" => "Lỗi: " . $conn->error]);
        }
    } else {
        echo json_encode(["message" => "Không có dữ liệu cập nhật"]);
    }
} else {
    echo json_encode(["message" => "Thiếu user_id"]);
}
?>

<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['username'], $data['password_hash'], $data['email'], $data['full_name'], $data['phone_number'])) {
    $username = $conn->real_escape_string($data['username']);
    $password = $conn->real_escape_string($data['password_hash']);
    $email = $conn->real_escape_string($data['email']);
    $full_name = $conn->real_escape_string($data['full_name']);
    $phone = $conn->real_escape_string($data['phone_number']);
    $sql = "INSERT INTO users (username, password_hash, email, full_name, phone_number) 
            VALUES ('$username', '$password', '$email', '$full_name', '$phone')";
    if ($conn->query($sql)) {
        echo json_encode(["message" => "Thêm thành công", "user_id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
}
?>

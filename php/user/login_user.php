<?php
header('Content-Type: application/json');

require_once 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password_hash = $data['password_hash'] ?? '';

$sql = "SELECT * FROM users WHERE username = ? AND password_hash = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["status" => "success", "user" => $user]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}

$conn->close();
?>

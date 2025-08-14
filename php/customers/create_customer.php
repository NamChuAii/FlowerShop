<?php
include 'connect.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['user_id'], $data['address'])) {
    $user_id = intval($data['user_id']);
    $address = $conn->real_escape_string($data['address']);
    $loyalty_points = isset($data['loyalty_points']) ? intval($data['loyalty_points']) : 0;

    // 1. Kiểm tra user_id có tồn tại trong bảng users không
    $res_user = $conn->query("SELECT full_name, email, phone_number FROM users WHERE user_id = $user_id");
    if ($res_user->num_rows === 0) {
        echo json_encode(["message" => "user_id không tồn tại trong bảng users"]);
        exit;
    }

    // 2. Kiểm tra user_id đã tồn tại trong bảng customers chưa
    $res_cust = $conn->query("SELECT customer_id FROM customers WHERE user_id = $user_id");
    if ($res_cust->num_rows > 0) {
        echo json_encode(["message" => "user_id này đã được gán cho một khách hàng rồi"]);
        exit;
    }

    // 3. Thêm mới nếu chưa tồn tại
    $user = $res_user->fetch_assoc();
    $full_name = $conn->real_escape_string($user['full_name']);
    $email = $conn->real_escape_string($user['email']);
    $phone = $conn->real_escape_string($user['phone_number']);

    $sql = "INSERT INTO customers (user_id, full_name, email, phone_number, address, loyalty_points)
            VALUES ($user_id, '$full_name', '$email', '$phone', '$address', $loyalty_points)";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Tạo khách hàng thành công", "customer_id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Lỗi khi thêm: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Thiếu user_id hoặc address"]);
}
?>

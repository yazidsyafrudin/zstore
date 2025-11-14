<?php
include 'connection.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'] ?? '';
$name = $data['recipient_name'] ?? '';
$phone = $data['phone'] ?? '';
$address = $data['address_line'] ?? '';
$city = $data['city'] ?? '';
$postal = $data['postal_code'] ?? '';

if (!$user_id || !$address) {
    echo json_encode(["success" => false, "message" => "user_id dan address wajib diisi"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO addresses (user_id, recipient_name, phone, address_line, city, postal_code) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $user_id, $name, $phone, $address, $city, $postal);
$stmt->execute();

echo json_encode(["success" => true, "message" => "Alamat berhasil ditambahkan"]);
?>

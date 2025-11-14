<?php
// CORS UNTUK FLUTTER WEB
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// ===============================

include 'connection.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_POST['user_id'] ?? '';
$product_id = $_POST['product_id'] ?? '';
$quantity = $_POST['quantity'] ?? 1;

if (!$user_id || !$product_id) {
    echo json_encode(["success" => false, "message" => "user_id dan product_id wajib diisi"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newQty = $row['quantity'] + $quantity;
    $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $update->bind_param("ii", $newQty, $row['id']);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $user_id, $product_id, $quantity);
    $insert->execute();
}

echo json_encode(["success" => true, "message" => "Produk ditambahkan"]);
?>

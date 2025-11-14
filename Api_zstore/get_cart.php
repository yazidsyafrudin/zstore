<?php
// === CORS FIX UNTUK FLUTTER WEB ===
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// ==================================

include 'connection.php';
header("Content-Type: application/json; charset=UTF-8");

$user_id = $_GET['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id diperlukan"]);
    exit;
}

$sql = "SELECT c.id AS cart_id, p.id AS product_id, p.title, p.price, c.quantity, 
        (p.price * c.quantity) AS total_price, 
        (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image_url
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
}

echo json_encode(["success" => true, "data" => $cart]);
?>

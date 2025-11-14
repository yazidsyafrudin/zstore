<?php
include 'connection.php';
header("Content-Type: application/json; charset=UTF-8");

$user_id = $_GET['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id diperlukan"]);
    exit;
}

$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($orders as &$order) {
    $order_id = $order['id'];
    $detail = $conn->prepare("SELECT oi.*, p.title FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id 
                              WHERE oi.order_id = ?");
    $detail->bind_param("i", $order_id);
    $detail->execute();
    $order['items'] = $detail->get_result()->fetch_all(MYSQLI_ASSOC);
}

echo json_encode(["success" => true, "data" => $orders]);
?>

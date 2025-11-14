<?php
include 'connection.php';
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id diperlukan"]);
    exit;
}

$conn->begin_transaction();

try {
    // ambil data keranjang
    $cart = $conn->prepare("SELECT c.product_id, c.quantity, p.price 
                            FROM cart c JOIN products p ON c.product_id = p.id 
                            WHERE c.user_id = ?");
    $cart->bind_param("i", $user_id);
    $cart->execute();
    $result = $cart->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Keranjang kosong"]);
        exit;
    }

    $total = 0;
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $total += $row['price'] * $row['quantity'];
        $items[] = $row;
    }

    // buat order baru
    $order = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $order->bind_param("id", $user_id, $total);
    $order->execute();
    $order_id = $conn->insert_id;

    // masukkan item order
    $insert_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($items as $item) {
        $insert_item->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $insert_item->execute();
    }

    // kosongkan keranjang
    $clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear->bind_param("i", $user_id);
    $clear->execute();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Pesanan berhasil dibuat", "order_id" => $order_id]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Gagal membuat pesanan"]);
}
?>

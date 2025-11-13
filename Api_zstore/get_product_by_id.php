<?php
// 🔹 Letakkan header CORS PALING ATAS sebelum yang lain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once "connection.php";

// Pastikan parameter id dikirim (via GET)
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Parameter 'id' tidak ditemukan"
    ]);
    exit();
}

$product_id = intval($_GET['id']);

// Ambil data produk berdasarkan id
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Ambil semua gambar produk
    $img_query = "SELECT image_url FROM product_images WHERE product_id = $product_id";
    $img_result = $conn->query($img_query);

    $images = [];
    if ($img_result && $img_result->num_rows > 0) {
        while ($img = $img_result->fetch_assoc()) {
            $images[] = $img['image_url'];
        }
    }

    // Format data produk
    $product = [
        "id" => (int)$row['id'],
        "title" => $row['title'],
        "description" => $row['description'],
        "category" => $row['category'],
        "price" => (double)$row['price'],
        "rating" => (double)$row['rating'],
        "isFavourite" => (bool)$row['is_favourite'],
        "isPopular" => (bool)$row['is_popular'],
        "images" => $images
    ];

    echo json_encode([
        "success" => true,
        "message" => "Detail produk ditemukan",
        "data" => $product
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Produk tidak ditemukan"
    ]);
}

$conn->close();
?>

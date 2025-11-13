<?php
// 🔹 Header CORS harus di paling atas
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once "connection.php";

// Query ambil semua produk
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];

        // Ambil semua gambar berdasarkan id produk
        $img_query = "SELECT image_url FROM product_images WHERE product_id = $product_id";
        $img_result = $conn->query($img_query);

        $images = [];
        if ($img_result && $img_result->num_rows > 0) {
            while ($img = $img_result->fetch_assoc()) {
                $images[] = $img['image_url'];
            }
        }

        // Format produk
        $products[] = [
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
    }

    echo json_encode([
        "success" => true,
        "message" => "Data produk ditemukan",
        "data" => $products
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Tidak ada produk ditemukan"
    ]);
}

$conn->close();
?>

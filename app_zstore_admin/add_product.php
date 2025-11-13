<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $rating = $_POST['rating'];
  $is_favourite = isset($_POST['is_favourite']) ? 1 : 0;
  $is_popular = isset($_POST['is_popular']) ? 1 : 0;

  // Simpan data produk
  $query = "INSERT INTO products (title, description, category, price, rating, is_favourite, is_popular)
            VALUES ('$title', '$description', '$category', '$price', '$rating', '$is_favourite', '$is_popular')";
  mysqli_query($conn, $query);

  $product_id = mysqli_insert_id($conn);

  // Simpan URL gambar (bisa lebih dari satu, dipisahkan koma)
  if (!empty($_POST['image_urls'])) {
    $urls = explode(',', $_POST['image_urls']);
    foreach ($urls as $url) {
      $url = trim($url);
      if ($url !== '') {
        mysqli_query($conn, "INSERT INTO product_images (product_id, image_url) VALUES ('$product_id', '$url')");
      }
    }
  }

  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <link rel="stylesheet" href="assets/css/edit_add.css">
  <style>
    textarea { width: 100%; height: 60px; }
  </style>
</head>
<body>
<div class="container">
  <h2>Tambah Produk</h2>
  <form method="POST">
    <label>Judul Produk:</label>
    <input type="text" name="title" required>

    <label>Deskripsi:</label>
    <textarea name="description" required></textarea>

    <label>Kategori:</label>
    <input type="text" name="category">

    <label>Harga:</label>
    <input type="number" step="0.01" name="price" required>

    <label>Rating:</label>
    <input type="number" step="0.1" name="rating" value="4.5">

    <label><input type="checkbox" name="is_favourite"> Favourite</label>
    <label><input type="checkbox" name="is_popular"> Popular</label>

    <label>URL Gambar Produk (pisahkan dengan koma jika lebih dari satu):</label>
    <textarea name="image_urls" placeholder="contoh: https://example.com/img1.jpg, https://example.com/img2.jpg"></textarea>

    <button type="submit">Simpan Produk</button>
  </form>
</div>
</body>
</html>

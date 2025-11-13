<?php
include 'config.php';

$id = $_GET['id'];

// Ambil data produk & gambar
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
$images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id=$id");

// --- Hapus gambar (berdasarkan id gambar) ---
if (isset($_GET['delete_image'])) {
  $image_id = $_GET['delete_image'];
  mysqli_query($conn, "DELETE FROM product_images WHERE id=$image_id AND product_id=$id");
  header("Location: edit_product.php?id=$id");
  exit;
}

// --- Proses update produk ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $rating = $_POST['rating'];
  $is_favourite = isset($_POST['is_favourite']) ? 1 : 0;
  $is_popular = isset($_POST['is_popular']) ? 1 : 0;

  // Update produk
  mysqli_query($conn, "UPDATE products SET 
    title='$title', 
    description='$description', 
    category='$category', 
    price='$price',
    rating='$rating', 
    is_favourite='$is_favourite', 
    is_popular='$is_popular'
    WHERE id=$id");

  // Tambah URL gambar baru
  if (!empty($_POST['image_urls'])) {
    $urls = explode(',', $_POST['image_urls']);
    foreach ($urls as $url) {
      $url = trim($url);
      if ($url !== '') {
        mysqli_query($conn, "INSERT INTO product_images (product_id, image_url) VALUES ('$id', '$url')");
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
  <title>Edit Produk</title>
  <link rel="stylesheet" href="assets/css/edit_add.css">
  <style>
    .image-list { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; }
    .img-item { position: relative; display: inline-block; }
    .preview { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd; }
    .delete-btn { position: absolute; top: 4px; right: 4px; background-color: red; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 14px; cursor: pointer; }
    textarea { width: 100%; height: 60px; }
  </style>
</head>
<body>
<div class="container">
  <h2>Edit Produk</h2>
  <form method="POST">
    <label>Judul:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($product['title']); ?>" required>

    <label>Deskripsi:</label>
    <textarea name="description"><?= htmlspecialchars($product['description']); ?></textarea>

    <label>Kategori:</label>
    <input type="text" name="category" value="<?= htmlspecialchars($product['category']); ?>">

    <label>Harga:</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>">

    <label>Rating:</label>
    <input type="number" step="0.1" name="rating" value="<?= $product['rating']; ?>">

    <label><input type="checkbox" name="is_favourite" <?= $product['is_favourite'] ? 'checked' : ''; ?>> Favourite</label>
    <label><input type="checkbox" name="is_popular" <?= $product['is_popular'] ? 'checked' : ''; ?>> Popular</label>

    <h4>Gambar Produk Saat Ini:</h4>
    <div class="image-list">
      <?php mysqli_data_seek($images, 0);
      while ($img = mysqli_fetch_assoc($images)): ?>
        <div class="img-item">
          <img src="<?= $img['image_url']; ?>" class="preview" alt="gambar produk">
          <a href="edit_product.php?id=<?= $id; ?>&delete_image=<?= $img['id']; ?>" 
             onclick="return confirm('Hapus gambar ini?')">
             <button type="button" class="delete-btn">×</button>
          </a>
        </div>
      <?php endwhile; ?>
    </div>

    <label>Tambah URL Gambar Baru (pisahkan dengan koma):</label>
    <textarea name="image_urls" placeholder="contoh: https://example.com/img1.jpg, https://example.com/img2.jpg"></textarea>

    <button type="submit">Update Produk</button>
  </form>
</div>
</body>
</html>

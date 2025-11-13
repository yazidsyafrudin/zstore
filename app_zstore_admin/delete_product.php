<?php
include 'config.php';

$id = $_GET['id'];

// Hapus gambar
$images = mysqli_query($conn, "SELECT * FROM product_image WHERE product_id=$id");
while ($img = mysqli_fetch_assoc($images)) {
  if (file_exists($img['image_url'])) {
    unlink($img['image_url']);
  }
}
mysqli_query($conn, "DELETE FROM product_image WHERE product_id=$id");

// Hapus produk
mysqli_query($conn, "DELETE FROM product WHERE id=$id");

header("Location: index.php");
exit;
?>

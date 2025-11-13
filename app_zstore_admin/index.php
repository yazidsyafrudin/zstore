<?php
include 'config.php';

// Query: ambil 1 image_url per produk (pakai MIN agar lolos ONLY_FULL_GROUP_BY)
$query = "
    SELECT 
        p.id, 
        p.title, 
        p.category, 
        p.price, 
        MIN(pi.image_url) AS image_url
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    GROUP BY p.id, p.title, p.category, p.price
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produk</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

    <h1>Daftar Produk</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Image URL</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['category']); ?></td>
                    <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($row['image_url']); ?></td> <!-- hanya teks -->
                    <td>
                        <a href="edit_product.php?id=<?= $row['id']; ?>">Edit</a> | 
                        <a href="delete_product.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus produk ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="add_product.php" class="add-btn">+ Tambah Produk Baru</a>

</body>
</html>

<?php
header("Content-Type: application/json; charset=UTF-8");

// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_zstore";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Gagal konek ke database"]);
    exit();
}

// Set karakter
$conn->set_charset("utf8mb4");
?>

<?php
// Izinkan koneksi dari Flutter
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari Flutter
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validasi data
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email dan password wajib diisi"]);
        exit();
    }

    // Cek apakah email sudah terdaftar
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Email sudah terdaftar"]);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registrasi berhasil"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal menyimpan data"]);
    }

    $stmt->close();
    $check->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Metode request tidak valid"]);
}
?>

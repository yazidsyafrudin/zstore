<?php
// 1. **PERBAIKAN UTAMA**: Tambahkan Header CORS di bagian paling atas
// Ini penting agar browser mengizinkan Flutter Web (yang berjalan di port berbeda) untuk mengakses API ini.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Penanganan Preflight Request (Request OPTIONS otomatis dari Browser)
// Jika metode adalah OPTIONS, langsung kirim header OK dan keluar
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Header untuk memastikan konten yang dikembalikan adalah JSON
header("Content-Type: application/json");

// Sertakan file koneksi database
include 'connection.php'; 

// 2. Cek apakah koneksi database berhasil
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// 3. Cek metode request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari request body (POST)
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input dasar
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email dan password wajib diisi."]);
        $conn->close();
        exit();
    }

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {
            echo json_encode([
                "success" => true,
                "message" => "Login berhasil",
                "user" => [
                    "id" => $user["id"],
                    "email" => $user["email"]
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Email atau password salah."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email atau password salah."]);
    }
} else {
    // 4. Menggunakan kode status HTTP 405 untuk Method Not Allowed
    http_response_code(405); 
    echo json_encode(["success" => false, "message" => "Metode request tidak valid."]);
}

$stmt->close();
$conn->close();
?>
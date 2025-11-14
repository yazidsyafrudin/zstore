<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

include 'connection.php';

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

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
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Metode request tidak valid."]);
}

if (isset($stmt)) { $stmt->close(); }
$conn->close();
?>

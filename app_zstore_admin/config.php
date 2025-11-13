<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "app_zstore";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

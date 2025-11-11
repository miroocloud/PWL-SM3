<?php
$servername = "localhost";
$port = 3306;
$username = "root";
$password = "";
$dbname = "perpustakaan_uts";

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

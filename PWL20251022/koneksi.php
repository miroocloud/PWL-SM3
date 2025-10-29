<?php
$srvname = "localhost";
$port = 3306;
$username = "root";
$password = "";
$database = "dbpertemuan6";

try {
    $conn = new PDO(
        "mysql:host=$srvname;port=$port;dbname=$database",
        $username,
        $password,
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "conn database success ~";
} catch (PDOException $e) {
    echo "conn database failed: " . $e->getMessage();
}

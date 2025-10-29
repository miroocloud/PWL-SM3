<?php
include "koneksi.php";

$id = 1;

$sql = "DELETE FROM barang WHERE id = :id";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([':id' => $id]);

if ($result) {
    echo "Data berhasil dihapus";
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error: {$errorInfo[2]}";
}

$conn = null;

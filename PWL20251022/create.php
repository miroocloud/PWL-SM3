<?php
include "koneksi.php";

$sql = "CREATE TABLE barang (
    id INT PRIMARY KEY,
    nama VARCHAR(40) DEFAULT NULL,
    hrg DOUBLE DEFAULT NULL,
    jml INT DEFAULT NULL,
    keterangan VARCHAR(100) DEFAULT NULL,
    foto VARCHAR(200) DEFAULT NULL
)";

if ($conn->exec($sql) !== false) {
    echo "Tabel berhasil dibuat";
} else {
    echo "Error: {$conn->errorInfo()}";
}

$conn = null;

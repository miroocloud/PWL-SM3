<?php
include "koneksi.php";

$id = 1;
$nama = "Pensil";
$hrg = 12000.50;
$jml = 50;
$keterangan = "Pensil 0.5mm, cocok untuk menulis dan menggambar";
$foto = "pensil.jpg";

$sql = "INSERT INTO barang (id, nama, hrg, jml, keterangan, foto)
        VALUES ($id, '$nama', $hrg, $jml, '$keterangan', '$foto')";

try {
    $result = $conn->exec($sql);
    echo "Data berhasil diinsert";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

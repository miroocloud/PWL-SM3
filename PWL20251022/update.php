<?php
include "koneksi.php";

$id = 1;
$nama = "Pensil Warna";
$hrg = 13000.00;
$jml = 60;
$keterangan = "Pensil warna, versi terbaru";
$foto = "pensil_warna_update.jpg";

$sql = "UPDATE barang SET nama = :nama, hrg = :hrg, jml = :jml, keterangan = :keterangan, foto = :foto WHERE id = :id";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':nama' => $nama,
    ':hrg' => $hrg,
    ':jml' => $jml,
    ':keterangan' => $keterangan,
    ':foto' => $foto,
    ':id' => $id
]);

if ($result) {
    echo "Data berhasil diupdate";
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error: {$errorInfo[2]}";
}

$conn = null;

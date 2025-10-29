<?php
include "koneksi.php";

$id = 1;
$nama = "Pensil Mekanik";
$hrg = 12000.50;
$jml = 50;
$keterangan = "Pensil mekanik 0.5mm, cocok untuk menulis dan menggambar";
$foto = "pensil_mekanik.jpg";

$sql = "INSERT INTO barang (id, nama, hrg, jml, keterangan, foto)
        VALUES ($id, '$nama', $hrg, $jml, '$keterangan', '$foto')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diinsert";
} else {
    echo "Error: {$conn->errorInfo()}";
}

$conn = null;

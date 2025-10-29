<?php
include "koneksi.php";

$fakeData = [
    [1, "Pensil", 12000.50, 50, "Pensil 0.5mm, cocok untuk menulis dan menggambar", "pensil.jpg"],
    [2, "Buku Tulis", 5000.00, 100, "Buku tulis 40 lembar, sampul tebal", "buku_tulis.jpg"],
    [3, "Penghapus", 2000.00, 75, "Penghapus putih, tidak merusak kertas", "penghapus.jpg"],
    [4, "Pulpen Biru", 3500.00, 60, "Pulpen tinta biru, nyaman digunakan", "pulpen_biru.jpg"],
    [5, "Spidol", 8000.00, 40, "Spidol permanen warna hitam", "spidol.jpg"]
];

foreach ($fakeData as $data) {
    [$id, $nama, $hrg, $jml, $keterangan, $foto] = $data;
    $sql = "INSERT INTO barang (id, nama, hrg, jml, keterangan, foto)
            VALUES ($id, \"$nama\", $hrg, $jml, \"$keterangan\", \"$foto\")";

    if ($conn->query($sql) === TRUE) {
        echo "Data id {$id} berhasil diinsert<br>";
    } else {
        echo "Error id {$id}: {$conn->errorInfo()}<br>";
    }
}

$conn = null;

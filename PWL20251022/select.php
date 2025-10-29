<?php
include "koneksi.php";

$sql = "SELECT * FROM barang";
$result = $conn->query($sql);

if ($result && $result->rowCount() > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Foto</th>
          </tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['hrg']}</td>
                <td>{$row['jml']}</td>
                <td>{$row['keterangan']}</td>
                <td>{$row['foto']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada data barang.";
}

$conn = null;

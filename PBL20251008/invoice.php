<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    $menuSelected = $_POST['menu'] ?? [];
    $catatan = $_POST['catatan'] ?? '';

    $pesananDetail = [];
    $totalKeseluruhan = 0;

    foreach ($menuSelected as $menu) {
        $fieldName = "jumlah_" . strtolower(str_replace(" ", "_", $menu));
        $jumlah = $_POST[$fieldName] ?? 0;
        
        if ($jumlah > 0) {
            $hargaFieldName = "harga_" . strtolower(str_replace(" ", "_", $menu));
            $harga = $_POST[$hargaFieldName] ?? 0;
            $subtotal = $harga * $jumlah;
            
            $pesananDetail[] = [
                "menu" => $menu,
                "harga_satuan" => $harga,
                "jumlah" => $jumlah,
                "subtotal" => $subtotal
            ];
            
            $totalKeseluruhan += $subtotal;
        }
    }

    $pesanan = [
        "nama" => $nama,
        "nohp" => $nohp,
        "alamat" => $alamat,
        "detail_pesanan" => $pesananDetail,
        "catatan" => $catatan,
        "total" => $totalKeseluruhan,
        "tanggal" => date("d-m-Y H:i:s")
    ];

    $file = 'history.json';
    $data = [];

    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    }

    $data[] = $pesanan;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Struk Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Struk Pemesanan</h3>
        
        <div class="mb-4">
            <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
            <p><strong>No HP:</strong> <?= htmlspecialchars($nohp) ?></p>
            <p><strong>Alamat:</strong> <?= htmlspecialchars($alamat) ?></p>
        </div>

        <div class="mb-4">
            <h5><strong>Detail Pesanan:</strong></h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesananDetail)): ?>
                            <?php foreach ($pesananDetail as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['menu']) ?></td>
                                <td>Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($item['jumlah']) ?></td>
                                <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada menu yang dipilih</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($catatan)): ?>
        <div class="mb-4">
            <p><strong>Catatan:</strong> <?= htmlspecialchars($catatan) ?></p>
        </div>
        <?php endif; ?>

        <hr>
        <h4 class="text-center">Total Harga: <strong class="text-success">Rp<?= number_format($totalKeseluruhan, 0, ',', '.') ?></strong></h4>
        <hr>
        
        <div class="text-center">
            <a href="index.php" class="btn btn-success mt-3">Pesan Lagi</a>
            <a href="history.php" class="btn btn-outline-secondary mt-3">Lihat Riwayat</a>
        </div>
    </div>
</div>

</body>
</html>

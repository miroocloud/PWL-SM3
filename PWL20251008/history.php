<?php
$file = 'history.json';
$pesananList = [];

if (file_exists($file)) {
    $pesananList = json_decode(file_get_contents($file), true);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Riwayat Pemesanan</h3>

        <?php if (empty($pesananList)) : ?>
            <p class="text-center text-muted">Belum ada pesanan.</p>
        <?php else : ?>
            <div class="accordion" id="accordionPesanan">
                <?php foreach ($pesananList as $index => $p) : ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $index ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <span><strong><?= htmlspecialchars($p['nama']) ?></strong> - <?= $p['tanggal'] ?></span>
                                    <span class="text-success"><strong>Rp<?= number_format($p['total'], 0, ',', '.') ?></strong></span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionPesanan">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Nama:</strong> <?= htmlspecialchars($p['nama']) ?></p>
                                        <p><strong>No HP:</strong> <?= htmlspecialchars($p['nohp']) ?></p>
                                        <p><strong>Alamat:</strong> <?= htmlspecialchars($p['alamat']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tanggal:</strong> <?= $p['tanggal'] ?></p>
                                        <?php if (!empty($p['catatan'])) : ?>
                                            <p><strong>Catatan:</strong> <?= htmlspecialchars($p['catatan']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h6><strong>Detail Pesanan:</strong></h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Menu</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($p['detail_pesanan']) && !empty($p['detail_pesanan'])) : ?>
                                                <?php foreach ($p['detail_pesanan'] as $item) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item['menu']) ?></td>
                                                        <td>Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                                        <td><?= htmlspecialchars($item['jumlah']) ?></td>
                                                        <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($p['menu'] ?? 'Menu tidak tersedia') ?></td>
                                                    <td>-</td>
                                                    <td><?= htmlspecialchars($p['jumlah'] ?? '0') ?></td>
                                                    <td>Rp<?= number_format($p['total'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-success">
                                                <th colspan="3" class="text-end">Total:</th>
                                                <th>Rp<?= number_format($p['total'], 0, ',', '.') ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Kembali</a>
            <?php if (!empty($pesananList)) : ?>
                <button class="btn btn-danger ms-2" onclick="clearHistory()">Hapus Riwayat</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function clearHistory() {
    if (confirm('Apakah Anda yakin ingin menghapus semua riwayat pesanan?')) {
        fetch('clear_history.php', {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data => {
            alert(data?.message || 'Riwayat berhasil dihapus!');
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
    }
}
</script>

</body>
</html>

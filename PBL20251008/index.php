<?php session_start(); ?>
<?php 

$menu_makanan = [
    "Nasi Goreng" => 15000,
    "Mie Goreng" => 12000,
    "Ayam Bakar" => 20000,
    "Es Teh" => 3000,
    "Es Jeruk" => 4000
];
    
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pemesanan Makanan Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Form Pemesanan Makanan Online</h2>
        <form action="invoice.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP <span class="text-danger">*</span></label>
                <input type="text" name="nohp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Menu Makanan <span class="text-danger">*</span></label>
                <div class="border p-3 rounded">
                    <?php foreach ($menu_makanan as $nama_menu => $harga): ?>
                        <?php 
                        $field_name = "jumlah_" . strtolower(str_replace(" ", "_", $nama_menu));
                        $checkbox_id = strtolower(str_replace(" ", "_", $nama_menu));
                        $harga_field = "harga_" . strtolower(str_replace(" ", "_", $nama_menu));
                        ?>
                        <div class="row mb-2">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="menu[]" value="<?= $nama_menu ?>" id="<?= $checkbox_id ?>">
                                    <label class="form-check-label" for="<?= $checkbox_id ?>">
                                        <?= $nama_menu ?> - Rp<?= number_format($harga, 0, ',', '.') ?>
                                    </label>
                                </div>
                                <!-- Hidden input untuk harga -->
                                <input type="hidden" name="<?= $harga_field ?>" value="<?= $harga ?>">
                            </div>
                            <div class="col-4">
                                <input type="number" name="<?= $field_name ?>" min="0" max="99" class="form-control form-control-sm" value="1">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Catatan Pesanan (Optional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan khusus untuk pesanan Anda..."></textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary px-4">Pesan Sekarang</button>
                <a href="history.php" class="btn btn-outline-secondary">Lihat Riwayat</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    
    checkboxes.forEach(function(checkbox) {
        const row = checkbox.closest('.row');
        const numberInput = row.querySelector('input[type="number"]');
        
        if (!checkbox.checked) {
            numberInput.disabled = true;
            numberInput.value = 0;
        }
        
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                numberInput.disabled = false;
                numberInput.value = 1;
            } else {
                numberInput.disabled = true;
                numberInput.value = 0;
            }
        });
    });
});
</script>

</body>
</html>

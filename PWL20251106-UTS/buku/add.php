<?php
require '../config/site.php';
require '../config/koneksi.php';

$title = "Tambah Buku - $app_name";
$current_page = 'buku';
$base_url = '../';

try {
    $penulis_stmt = $conn->query("SELECT id_penulis, nama FROM penulis ORDER BY nama ASC");
    $penulis_list = $penulis_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $penulis_list = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $id_penulis = !empty($_POST['id_penulis']) ? (int)$_POST['id_penulis'] : null;
    $isbn = trim($_POST['isbn'] ?? '');
    $tahun_terbit = !empty($_POST['tahun_terbit']) ? (int)$_POST['tahun_terbit'] : null;
    $kategori = trim($_POST['kategori'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $jumlah_halaman = !empty($_POST['jumlah_halaman']) ? (int)$_POST['jumlah_halaman'] : null;
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status = $_POST['status'] ?? 'tersedia';

    $errors = [];

    if (empty($judul)) {
        $errors[] = "Judul buku harus diisi!";
    }

    if (!empty($isbn)) {
        try {
            $check_stmt = $conn->prepare("SELECT id_buku FROM buku WHERE isbn = ?");
            $check_stmt->execute([$isbn]);
            if ($check_stmt->rowCount() > 0) {
                $errors[] = "ISBN sudah terdaftar!";
            }
        } catch (PDOException $e) {
            $errors[] = "Error checking ISBN: " . $e->getMessage();
        }
    }

    if (!empty($tahun_terbit) && ($tahun_terbit < 1000 || $tahun_terbit > date('Y'))) {
        $errors[] = "Tahun terbit tidak valid!";
    }

    if (!empty($jumlah_halaman) && $jumlah_halaman <= 0) {
        $errors[] = "Jumlah halaman harus lebih dari 0!";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO buku (judul, id_penulis, isbn, tahun_terbit, kategori, penerbit, jumlah_halaman, deskripsi, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $judul,
                $id_penulis,
                $isbn,
                $tahun_terbit,
                $kategori,
                $penerbit,
                $jumlah_halaman,
                $deskripsi,
                $status
            ]);

            header("Location: list.php?success=add");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error saving data: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php include '../components/head.php'; ?>
    <link href="../style/main.css" rel="stylesheet">
    <style>
        .main-content {
            margin-top: 76px;
        }

        .page-title {
            margin-bottom: 2rem;
            padding-top: 2rem;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 1.5rem;
        }

        .btn-submit {
            background-color: #059669;
            border-color: #059669;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #047857;
            border-color: #047857;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .btn-cancel {
            background-color: #6b7280;
            border-color: #6b7280;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.3);
        }

        .form-floating label {
            color: #6b7280;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .required {
            color: #dc2626;
        }

        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #0284c7;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .info-box i {
            color: #0284c7;
        }

        .form-section {
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            color: #374151;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .char-counter {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: right;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body>
    <?php include '../components/navbar.php'; ?>

    <!-- Main Content -->
    <div class="container main-content py-4">
        <!-- Page Title -->
        <div class="row align-items-center page-title">
            <div class="col-md-6">
                <h2 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Buku
                </h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="list.php" class="btn btn-cancel">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Form Container -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-journal-plus me-2"></i>Form Data Buku
                        </h5>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="" id="addBukuForm">
                            <!-- Informasi Dasar -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-book me-2"></i>Informasi Dasar
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control"
                                                id="judul"
                                                name="judul"
                                                placeholder="Judul Buku"
                                                value="<?= htmlspecialchars($_POST['judul'] ?? '') ?>"
                                                maxlength="200"
                                                required>
                                            <label for="judul">Judul Buku <span class="required">*</span></label>
                                        </div>
                                        <div class="char-counter">
                                            <span id="judulCounter">0</span>/200 karakter
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control"
                                                id="isbn"
                                                name="isbn"
                                                placeholder="ISBN"
                                                value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>"
                                                maxlength="20">
                                            <label for="isbn">ISBN</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="id_penulis" name="id_penulis">
                                                <option value="">-- Pilih Penulis --</option>
                                                <?php foreach ($penulis_list as $penulis): ?>
                                                    <option value="<?= $penulis['id_penulis'] ?>"
                                                        <?= (isset($_POST['id_penulis']) && $_POST['id_penulis'] == $penulis['id_penulis']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($penulis['nama']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="id_penulis">Penulis</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control"
                                                id="penerbit"
                                                name="penerbit"
                                                placeholder="Penerbit"
                                                value="<?= htmlspecialchars($_POST['penerbit'] ?? '') ?>"
                                                maxlength="100">
                                            <label for="penerbit">Penerbit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kategori & Detail -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-tags me-2"></i>Kategori & Detail
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" id="kategori" name="kategori">
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="Fiksi" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Fiksi') ? 'selected' : '' ?>>Fiksi</option>
                                                <option value="Non-Fiksi" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Non-Fiksi') ? 'selected' : '' ?>>Non-Fiksi</option>
                                                <option value="Sains" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Sains') ? 'selected' : '' ?>>Sains</option>
                                                <option value="Teknologi" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Teknologi') ? 'selected' : '' ?>>Teknologi</option>
                                                <option value="Sejarah" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Sejarah') ? 'selected' : '' ?>>Sejarah</option>
                                                <option value="Biografi" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Biografi') ? 'selected' : '' ?>>Biografi</option>
                                                <option value="Pendidikan" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Pendidikan') ? 'selected' : '' ?>>Pendidikan</option>
                                                <option value="Agama" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Agama') ? 'selected' : '' ?>>Agama</option>
                                                <option value="Lainnya" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                                            </select>
                                            <label for="kategori">Kategori</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number"
                                                class="form-control"
                                                id="tahun_terbit"
                                                name="tahun_terbit"
                                                placeholder="Tahun Terbit"
                                                value="<?= htmlspecialchars($_POST['tahun_terbit'] ?? '') ?>"
                                                min="1000"
                                                max="<?= date('Y') ?>">
                                            <label for="tahun_terbit">Tahun Terbit</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number"
                                                class="form-control"
                                                id="jumlah_halaman"
                                                name="jumlah_halaman"
                                                placeholder="Jumlah Halaman"
                                                value="<?= htmlspecialchars($_POST['jumlah_halaman'] ?? '') ?>"
                                                min="1"
                                                max="9999">
                                            <label for="jumlah_halaman">Jumlah Halaman</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Deskripsi -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-gear me-2"></i>Status & Deskripsi
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="status" name="status">
                                                <option value="tersedia" <?= (isset($_POST['status']) && $_POST['status'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                                                <option value="dipinjam" <?= (isset($_POST['status']) && $_POST['status'] == 'dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
                                                <option value="rusak" <?= (isset($_POST['status']) && $_POST['status'] == 'rusak') ? 'selected' : '' ?>>Rusak</option>
                                            </select>
                                            <label for="status">Status Buku</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control"
                                                id="deskripsi"
                                                name="deskripsi"
                                                placeholder="Deskripsi Buku"
                                                style="height: 120px"
                                                maxlength="500"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
                                            <label for="deskripsi">Deskripsi Buku</label>
                                        </div>
                                        <div class="char-counter">
                                            <span id="deskripsiCounter">0</span>/500 karakter
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="list.php" class="btn btn-cancel w-100">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-submit w-100">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Buku
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
    <?php include '../components/scripts.php'; ?>

    <script>
        function updateCounter(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);

            input.addEventListener('input', function() {
                const currentLength = this.value.length;
                counter.textContent = currentLength;

                if (currentLength > maxLength * 0.9) {
                    counter.style.color = '#dc2626';
                } else {
                    counter.style.color = '#6b7280';
                }
            });

            counter.textContent = input.value.length;
        }

        updateCounter('judul', 'judulCounter', 200);
        updateCounter('deskripsi', 'deskripsiCounter', 500);

        document.getElementById('addBukuForm').addEventListener('submit', function(e) {
            const judul = document.getElementById('judul').value.trim();
            const tahun_terbit = document.getElementById('tahun_terbit').value;
            const jumlah_halaman = document.getElementById('jumlah_halaman').value;

            if (judul === '') {
                e.preventDefault();
                alert('Judul buku harus diisi!');
                document.getElementById('judul').focus();
                return false;
            }

            if (tahun_terbit && (tahun_terbit < 1000 || tahun_terbit > new Date().getFullYear())) {
                e.preventDefault();
                alert('Tahun terbit tidak valid!');
                document.getElementById('tahun_terbit').focus();
                return false;
            }

            if (jumlah_halaman && jumlah_halaman <= 0) {
                e.preventDefault();
                alert('Jumlah halaman harus lebih dari 0!');
                document.getElementById('jumlah_halaman').focus();
                return false;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 3000);
        });

        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('show')) {
                    new bootstrap.Alert(alert).close();
                }
            });
        }, 10000);

        document.getElementById('isbn').addEventListener('input', function() {
            let value = this.value.replace(/[^0-9\-]/g, '');
            this.value = value;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tahunTerbit = document.getElementById('tahun_terbit');
            if (!tahunTerbit.value) {
                tahunTerbit.value = new Date().getFullYear();
            }
        });
    </script>
</body>

</html>
<?php
require '../config/site.php';
require '../config/koneksi.php';

$title = "Edit Penulis - $app_name";
$current_page = 'penulis';
$base_url = '../';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: list.php?error=invalid_id");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM penulis WHERE id_penulis = ?");
    $stmt->execute([$id]);
    $penulis = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penulis) {
        header("Location: list.php?error=not_found");
        exit;
    }
} catch (PDOException $e) {
    header("Location: list.php?error=database");
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telepon = trim($_POST['telepon'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');

        $errors = [];

        if (empty($nama)) {
            $errors[] = "Nama penulis harus diisi!";
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid!";
        }

        if (!empty($email)) {
            try {
                $check_stmt = $conn->prepare("SELECT id_penulis FROM penulis WHERE email = ? AND id_penulis != ?");
                $check_stmt->execute([$email, $id]);
                if ($check_stmt->rowCount() > 0) {
                    $errors[] = "Email sudah terdaftar untuk penulis lain!";
                }
            } catch (PDOException $e) {
                $errors[] = "Error checking email: " . $e->getMessage();
            }
        }

        if (empty($errors)) {
            try {
                $stmt = $conn->prepare("UPDATE penulis SET nama = ?, email = ?, telepon = ?, alamat = ? WHERE id_penulis = ?");
                $stmt->execute([$nama, $email, $telepon, $alamat, $id]);

                header("Location: list.php?success=edit");
                exit;
            } catch (PDOException $e) {
                $errors[] = "Error updating data: " . $e->getMessage();
            }
        }
        break;

    default:
        $_POST = $penulis;
        break;
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 1.5rem;
        }

        .btn-update {
            background-color: #059669;
            border-color: #059669;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
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

        .btn-back {
            background-color: #1e40af;
            border-color: #1e40af;
            color: white;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
        }

        .form-floating label {
            color: #6b7280;
        }

        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
        }

        .required {
            color: #dc2626;
        }

        .info-box {
            background-color: #fffbeb;
            border: 1px solid #f59e0b;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .info-box i {
            color: #f59e0b;
        }

        .current-data {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 600;
            color: #374151;
            width: 30%;
        }

        .data-value {
            color: #6b7280;
            width: 70%;
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
                    <i class="bi bi-pencil-square me-2"></i>Edit Penulis
                </h2>
                <small class="text-muted">ID: <?= $penulis['id_penulis'] ?></small>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="list.php" class="btn btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
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
            <div class="col-lg-8">
                <!-- Form Container -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i>Form Edit Data Penulis
                        </h5>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="" id="editPenulisForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control"
                                            id="nama"
                                            name="nama"
                                            placeholder="Nama Penulis"
                                            value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
                                            required>
                                        <label for="nama">Nama Penulis <span class="required">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="Email"
                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                        <label for="email">Email</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel"
                                            class="form-control"
                                            id="telepon"
                                            name="telepon"
                                            placeholder="Telepon"
                                            value="<?= htmlspecialchars($_POST['telepon'] ?? '') ?>">
                                        <label for="telepon">Telepon</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control"
                                            id="alamat_singkat"
                                            name="alamat_singkat"
                                            placeholder="Kota/Kabupaten"
                                            value="<?= htmlspecialchars(explode(',', $_POST['alamat'] ?? '')[0] ?? '') ?>">
                                        <label for="alamat_singkat">Kota/Kabupaten</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control"
                                            id="alamat"
                                            name="alamat"
                                            placeholder="Alamat Lengkap"
                                            style="height: 100px"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                                        <label for="alamat">Alamat Lengkap</label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="list.php" class="btn btn-cancel w-100">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-update w-100">
                                        <i class="bi bi-check-circle me-2"></i>Update Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Terakhir diubah: <?= date('d/m/Y H:i') ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box mt-4">
                    <div class="d-flex align-items-start">
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">Edit Data Penulis</h6>
                            <ul class="mb-0 small text-muted">
                                <li>Ubah data yang diperlukan pada form di atas</li>
                                <li>Nama penulis wajib diisi</li>
                                <li>Email harus unique (tidak boleh sama dengan penulis lain)</li>
                                <li>Klik "Update Data" untuk menyimpan perubahan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
    <?php include '../components/scripts.php'; ?>

    <script>
        document.getElementById('editPenulisForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();

            if (nama === '') {
                e.preventDefault();
                alert('Nama penulis harus diisi!');
                document.getElementById('nama').focus();
                return false;
            }

            if (!confirm('Apakah Anda yakin ingin mengupdate data penulis ini?')) {
                e.preventDefault();
                return false;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengupdate...';
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

        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailPattern.test(email)) {
                this.setCustomValidity('Format email tidak valid');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });

        document.getElementById('nama').addEventListener('input', function() {
            const maxLength = 100;
            const currentLength = this.value.length;

            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
            }
        });

        document.getElementById('telepon').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('0')) {
                value = '0' + value;
            }
            this.value = value;
        });

        const originalData = {
            nama: '<?= htmlspecialchars($penulis['nama']) ?>',
            email: '<?= htmlspecialchars($penulis['email']) ?>',
            telepon: '<?= htmlspecialchars($penulis['telepon']) ?>',
            alamat: '<?= htmlspecialchars($penulis['alamat']) ?>'
        };

        ['nama', 'email', 'telepon', 'alamat'].forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    if (this.value !== originalData[field]) {
                        this.classList.add('border-warning');
                    } else {
                        this.classList.remove('border-warning');
                    }
                });
            }
        });
    </script>
</body>

</html>
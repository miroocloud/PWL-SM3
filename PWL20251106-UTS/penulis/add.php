<?php
require '../config/site.php';
require '../config/koneksi.php';

$title = "Tambah Penulis - $app_name";
$current_page = 'penulis';
$base_url = '../';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $check_stmt = $conn->prepare("SELECT id_penulis FROM penulis WHERE email = ?");
            $check_stmt->execute([$email]);
            if ($check_stmt->rowCount() > 0) {
                $errors[] = "Email sudah terdaftar!";
            }
        } catch (PDOException $e) {
            $errors[] = "Error checking email: " . $e->getMessage();
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO penulis (nama, email, telepon, alamat) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $telepon, $alamat]);

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

        .form-control:focus {
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
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Penulis
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
            <div class="col-lg-8">
                <!-- Form Container -->
                <div class="form-container">
                    <div class="form-header">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i>Form Data Penulis
                        </h5>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="" id="addPenulisForm">
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
                                            id="alamat"
                                            name="alamat"
                                            placeholder="Alamat"
                                            value="<?= htmlspecialchars($_POST['alamat'] ?? '') ?>">
                                        <label for="alamat">Alamat</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control"
                                            id="alamat_lengkap"
                                            name="alamat"
                                            placeholder="Alamat Lengkap"
                                            style="height: 100px"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                                        <label for="alamat_lengkap">Alamat Lengkap</label>
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
                                    <button type="submit" class="btn btn-submit w-100">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box mt-4">
                    <div class="d-flex align-items-start">
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">Informasi Pengisian Form</h6>
                            <ul class="mb-0 small text-muted">
                                <li>Nama penulis wajib diisi</li>
                                <li>Email dan telepon bersifat opsional</li>
                                <li>Pastikan email yang dimasukkan valid dan belum terdaftar</li>
                                <li>Alamat dapat diisi dengan detail lokasi penulis</li>
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
        document.getElementById('addPenulisForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();

            if (nama === '') {
                e.preventDefault();
                alert('Nama penulis harus diisi!');
                document.getElementById('nama').focus();
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
    </script>
</body>

</html>
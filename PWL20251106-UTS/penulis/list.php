<?php
require '../config/site.php';
require '../config/koneksi.php';

$title = "Kelola Penulis - $app_name";
$current_page = 'penulis';
$base_url = '../';

try {
    $stmt = $conn->query("SELECT * FROM penulis ORDER BY id_penulis DESC");
    $penulis = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $penulis = [];
    $error_message = "Error: " . $e->getMessage();
}

// Handle delete request
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $delete_stmt = $conn->prepare("DELETE FROM penulis WHERE id_penulis = ?");
        $delete_stmt->execute([$_GET['delete']]);
        header("Location: list.php?success=delete");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error deleting record: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php include '../components/head.php'; ?>
    <link href="../style/main.css" rel="stylesheet">
    <style>
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .btn-action {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 20px;
            margin: 0 2px;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            color: #6b7280;
        }

        .empty-state h4 {
            color: #374151;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-top: 76px;
        }

        .page-title {
            margin-bottom: 2rem;
            padding-top: 2rem;
        }

        .btn-add-main {
            background-color: #f59e0b;
            border-color: #f59e0b;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-add-main:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
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
                    <i class="bi bi-person-lines-fill me-2"></i>Kelola Penulis
                </h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="add.php" class="btn btn-add-main">
                    <i class="bi bi-person-plus me-2"></i>Tambah Penulis
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?php
                switch ($_GET['success']) {
                    case 'add':
                        echo 'Penulis berhasil ditambahkan!';
                        break;
                    case 'edit':
                        echo 'Data penulis berhasil diupdate!';
                        break;
                    case 'delete':
                        echo 'Penulis berhasil dihapus!';
                        break;
                    default:
                        echo 'Operasi berhasil!';
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= htmlspecialchars($error_message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-primary mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-primary"><?= count($penulis) ?></h4>
                        <p class="text-muted mb-0">Total Penulis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check text-success mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-success">
                            <?= count(array_filter($penulis, fn($p) => !empty($p['email']))) ?>
                        </h4>
                        <p class="text-muted mb-0">Dengan Email</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-telephone text-info mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-info">
                            <?= count(array_filter($penulis, fn($p) => !empty($p['telepon']))) ?>
                        </h4>
                        <p class="text-muted mb-0">Dengan Telepon</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-plus text-warning mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-warning"><?= date('M Y') ?></h4>
                        <p class="text-muted mb-0">Periode</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <div class="p-4 border-bottom bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-table me-2"></i>Data Penulis
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="input-group" style="max-width: 300px; margin-left: auto;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari penulis..." id="searchInput">
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($penulis)): ?>
                <div class="empty-state">
                    <i class="bi bi-person-x-fill"></i>
                    <h4>Belum Ada Data Penulis</h4>
                    <p>Mulai dengan menambahkan penulis pertama ke dalam sistem perpustakaan Anda.</p>
                    <a href="add.php" role="button" class="btn btn-primary">
                        Tambah Penulis
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="penulisTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="25%">Nama Penulis</th>
                                <th width="20%">Email</th>
                                <th width="15%">Telepon</th>
                                <th width="20%">Alamat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($penulis as $row): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['email'])): ?>
                                            <a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($row['email']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['telepon'])): ?>
                                            <a href="tel:<?= htmlspecialchars($row['telepon']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($row['telepon']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= !empty($row['alamat']) ? htmlspecialchars($row['alamat']) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="edit.php?id=<?= $row['id_penulis'] ?>" class="btn btn-outline-primary btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-action" title="Hapus"
                                                onclick="confirmDelete(<?= $row['id_penulis'] ?>, '<?= htmlspecialchars($row['nama']) ?>')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus penulis <strong id="deleteNama"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Tindakan ini tidak dapat dibatalkan!</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="deleteConfirm" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
    <?php include '../components/scripts.php'; ?>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let table = document.getElementById('penulisTable');
            let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                let nama = rows[i].cells[1].textContent.toLowerCase();
                let email = rows[i].cells[2].textContent.toLowerCase();
                let telepon = rows[i].cells[3].textContent.toLowerCase();

                if (nama.includes(filter) || email.includes(filter) || telepon.includes(filter)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });

        function confirmDelete(id, nama) {
            document.getElementById('deleteNama').textContent = nama;
            document.getElementById('deleteConfirm').href = 'list.php?delete=' + id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('show')) {
                    new bootstrap.Alert(alert).close();
                }
            });
        }, 5000);
    </script>
</body>

</html>
<?php
require '../config/site.php';
require '../config/koneksi.php';

$title = "Kelola Buku - $app_name";
$current_page = 'buku';
$base_url = '../';

try {
    $stmt = $conn->query("
        SELECT b.*, p.nama as nama_penulis
        FROM buku b
        LEFT JOIN penulis p ON b.id_penulis = p.id_penulis
        ORDER BY b.id_buku DESC
    ");
    $buku = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $buku = [];
    $error_message = "Error: " . $e->getMessage();
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $delete_stmt = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
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
            background-color: #1e40af;
            border-color: #1e40af;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-add-main:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }

        .book-cover {
            width: 50px;
            height: 70px;
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .book-info {
            flex: 1;
        }

        .book-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .book-author {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-tersedia {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-dipinjam {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-rusak {
            background-color: #fee2e2;
            color: #991b1b;
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
                    <i class="bi bi-journal-bookmark-fill me-2"></i>Kelola Buku
                </h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="add.php" class="btn btn-add-main">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku
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
                        echo 'Buku berhasil ditambahkan!';
                        break;
                    case 'edit':
                        echo 'Data buku berhasil diupdate!';
                        break;
                    case 'delete':
                        echo 'Buku berhasil dihapus!';
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
                        <i class="bi bi-book text-primary mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-primary"><?= count($buku) ?></h4>
                        <p class="text-muted mb-0">Total Buku</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-success">
                            <?= count(array_filter($buku, fn($b) => ($b['status'] ?? 'tersedia') == 'tersedia')) ?>
                        </h4>
                        <p class="text-muted mb-0">Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-book-half text-warning mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-warning">
                            <?= count(array_filter($buku, fn($b) => ($b['status'] ?? 'tersedia') == 'dipinjam')) ?>
                        </h4>
                        <p class="text-muted mb-0">Dipinjam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check text-info mb-2" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold text-info"><?= date('Y') ?></h4>
                        <p class="text-muted mb-0">Tahun Ini</p>
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
                            <i class="bi bi-table me-2"></i>Data Buku
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="input-group" style="max-width: 300px; margin-left: auto;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari buku..." id="searchInput">
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($buku)): ?>
                <div class="empty-state">
                    <i class="bi bi-journal-x"></i>
                    <h4>Belum Ada Data Buku</h4>
                    <p>Mulai dengan menambahkan buku pertama ke dalam sistem perpustakaan Anda.</p>
                    <a href="add.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Buku Pertama
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="bukuTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="30%">Judul Buku</th>
                                <th width="15%">Penulis</th>
                                <th width="10%">Tahun</th>
                                <th width="15%">Kategori</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($buku as $row): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="book-cover me-3">
                                                <?= strtoupper(substr($row['judul'], 0, 1)) ?>
                                            </div>
                                            <div class="book-info">
                                                <div class="book-title"><?= htmlspecialchars($row['judul']) ?></div>
                                                <div class="book-author">
                                                    <small>ID: <?= $row['id_buku'] ?> |
                                                        ISBN: <?= htmlspecialchars($row['isbn'] ?? '-') ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['nama_penulis'])): ?>
                                            <span class="text-dark fw-semibold"><?= htmlspecialchars($row['nama_penulis']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak diketahui</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= !empty($row['tahun_terbit']) ? htmlspecialchars($row['tahun_terbit']) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['kategori'])): ?>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($row['kategori']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $status = $row['status'] ?? 'tersedia';
                                        $status_class = '';
                                        switch ($status) {
                                            case 'tersedia':
                                                $status_class = 'status-tersedia';
                                                $status_text = 'Tersedia';
                                                break;
                                            case 'dipinjam':
                                                $status_class = 'status-dipinjam';
                                                $status_text = 'Dipinjam';
                                                break;
                                            case 'rusak':
                                                $status_class = 'status-rusak';
                                                $status_text = 'Rusak';
                                                break;
                                            default:
                                                $status_class = 'status-tersedia';
                                                $status_text = 'Tersedia';
                                        }
                                        ?>
                                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="view.php?id=<?= $row['id_buku'] ?>" class="btn btn-outline-info btn-action" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit.php?id=<?= $row['id_buku'] ?>" class="btn btn-outline-primary btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-action" title="Hapus"
                                                onclick="confirmDelete(<?= $row['id_buku'] ?>, '<?= htmlspecialchars($row['judul']) ?>')">
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
                    <p>Apakah Anda yakin ingin menghapus buku <strong id="deleteJudul"></strong>?</p>
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
            let table = document.getElementById('bukuTable');
            let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                let judul = rows[i].cells[1].textContent.toLowerCase();
                let penulis = rows[i].cells[2].textContent.toLowerCase();
                let kategori = rows[i].cells[4].textContent.toLowerCase();

                if (judul.includes(filter) || penulis.includes(filter) || kategori.includes(filter)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });

        function confirmDelete(id, judul) {
            document.getElementById('deleteJudul').textContent = judul;
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
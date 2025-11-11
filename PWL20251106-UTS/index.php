<?php
require 'config/site.php';
require 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'components/head.php'; ?>
    <link href="style/main.css" rel="stylesheet">
</head>

<body>
    <?php include 'components/navbar.php'; ?>

    <section id="home" class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Sistem Manajemen<br>
                        <span class="text-warning">Perpustakaan Digital</span>
                    </h1>
                    <p class="lead mb-4">
                        Kelola koleksi buku dan data penulis dengan mudah menggunakan sistem modern yang terintegrasi.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="buku/list.php" class="btn btn-warning-custom btn-blue-custom">
                            <i class="bi bi-book me-2"></i>Kelola Buku
                        </a>
                        <a href="penulis/list.php" class="btn btn-outline-light btn-blue-custom">
                            <i class="bi bi-person-plus me-2"></i>Kelola Penulis
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-books" style="font-size: 12rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-3">Fitur Unggulan</h2>
                <hr class="section-divider">
                <p class="text-muted">Solusi lengkap untuk manajemen perpustakaan modern</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card card-hover h-100 text-center p-4">
                        <div class="feature-icon bg-primary text-white">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Manajemen Buku</h5>
                        <p class="text-muted">Kelola koleksi buku dengan fitur lengkap untuk menambah, mengedit, dan menghapus data buku.</p>
                        <a href="buku/list.php" class="btn btn-primary btn-sm btn-blue-custom mt-auto">
                            Kelola Buku <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="card card-hover h-100 text-center p-4">
                        <div class="feature-icon bg-success text-white">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Data Penulis</h5>
                        <p class="text-muted">Kelola informasi lengkap tentang penulis buku termasuk biodata dan karya-karyanya.</p>
                        <a href="penulis/list.php" class="btn btn-success btn-sm btn-blue-custom mt-auto">
                            Kelola Penulis <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 stats-section">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card stat-card p-4 h-100">
                        <i class="bi bi-book text-primary mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-primary">1000+</h3>
                        <p class="text-muted mb-0">Koleksi Buku</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card p-4 h-100">
                        <i class="bi bi-people text-success mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-success">150+</h3>
                        <p class="text-muted mb-0">Penulis Terdaftar</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card p-4 h-100">
                        <i class="bi bi-award text-warning mb-3" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold text-warning">24/7</h3>
                        <p class="text-muted mb-0">Akses Online</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/scripts.php'; ?>
</body>

</html>
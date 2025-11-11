<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="<?= $base_url ?? '' ?>index.php">
            <i class="bi bi-book-half me-2"></i>Perpustakaan Digital
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= ($current_page == 'penulis') ? 'active' : '' ?>" href="<?= $base_url ?? '' ?>penulis/list.php">
                        <i class="bi bi-person-lines-fill me-1"></i>Penulis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= ($current_page == 'buku') ? 'active' : '' ?>" href="<?= $base_url ?? '' ?>buku/list.php">
                        <i class="bi bi-journal-bookmark me-1"></i>Buku
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
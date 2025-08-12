<?php /** main_layout.php - CI4 view */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title><?= $this->renderSection('title') ?> - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/layout.css') ?>">
</head>
<body>
<div class="app-root">
    <aside id="app-sidebar" class="sidebar shadow-sm" aria-label="Sidebar Navigation">
        <div class="sidebar-top d-flex align-items-center justify-content-between px-3">
            <div class="brand-container d-flex flex-column align-items-center text-center gap-2 mt-3">
                <a href="<?= base_url('dashboard') ?>"><img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="logo-img"></a>
                <div class="brand-text-large">Perpustakaan</div>
                <div class="brand-text-large">SMK BERBUDI</div>
            </div>
            <button class="btn btn-ghost d-md-none" id="btnCloseSidebar" aria-label="Tutup sidebar">

            </button>
        </div>
        <nav class="sidebar-nav mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= (service('uri')->getSegment(1) == '' || service('uri')->getSegment(1) == 'dashboard') ? 'active' : '' ?>"
                        href="<?= base_url('dashboard') ?>">
                        <i class="fa fa-home me-2"></i> <span class="link-text">Dashboard</span>
                    </a>
                </li>
                <?php
                    $segment = service('uri')->getSegment(1);
                    $isDataMaster = in_array($segment, ['buku','anggota','kategori']);
                ?>
                <li class="nav-item has-sub <?= $isDataMaster ? 'open' : '' ?>">
                    <a href="#menu-data-master" class="nav-link submenu-toggle <?= $isDataMaster ? '' : '' ?>" data-bs-toggle="collapse" aria-expanded="<?= $isDataMaster ? 'true' : 'false' ?>">
                        <i class="fa fa-database me-2"></i> <span class="link-text">Data Master</span>
                        <i class="fa fa-chevron-right ms-auto chevron"></i>
                    </a>
                    <ul id="menu-data-master" class="collapse list-unstyled submenu <?= $isDataMaster ? 'show' : '' ?>">
                        <li><a class="nav-link <?= $segment=='buku' ? 'active' : '' ?>" href="<?= base_url('buku') ?>">Buku</a></li>
                        <li><a class="nav-link <?= $segment=='anggota' ? 'active' : '' ?>" href="<?= base_url('anggota') ?>">Anggota</a></li>
                        <li><a class="nav-link <?= $segment=='kategori' ? 'active' : '' ?>" href="<?= base_url('kategori') ?>">Kategori</a></li>
                    </ul>
                </li>
                <?php $isTransaksi = in_array($segment, ['peminjaman','absensi']); ?>
                <li class="nav-item has-sub <?= $isTransaksi ? 'open' : '' ?>">
                    <a href="#menu-transaksi" class="nav-link submenu-toggle" data-bs-toggle="collapse" aria-expanded="<?= $isTransaksi ? 'true' : 'false' ?>">
                        <i class="fa fa-exchange-alt me-2"></i> <span class="link-text">Transaksi</span>
                        <i class="fa fa-chevron-right ms-auto chevron"></i>
                    </a>
                    <ul id="menu-transaksi" class="collapse list-unstyled submenu <?= $isTransaksi ? 'show' : '' ?>">
                        <li><a class="nav-link <?= $segment=='peminjaman' ? 'active' : '' ?>" href="<?= base_url('peminjaman') ?>">Peminjaman</a></li>
                        <li><a class="nav-link <?= $segment=='absensi' ? 'active' : '' ?>" href="<?= base_url('absensi') ?>">Absensi Pengunjung</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer p-3 small text-muted">
        </div>
    </aside>
    <div id="sidebar-overlay" class="sidebar-overlay"></div>
    <div class="main">
        <header class="navbar shadow-sm">
            <div class="container-fluid d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-ghost" id="btnToggleSidebar" aria-label="Toggle sidebar">
                        <i class="fa fa-bars fa-lg"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center user-info gap-2">
                        <span class="d-none d-md-inline">Pustakawan</span>
                        <div class="user-icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END NAVBAR -->

        <main class="content">
            <div class="container-fluid p-3">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>"></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($breadcrumb ?? 'General') ?></li>
                    </ol>
                </nav>

                <!-- page content -->
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <footer class="footer text-center small text-muted py-3">
            Perpustakaan SMK Berbudi
        </footer>
    </div>
    <!-- END MAIN -->

</div>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Small JS to control sidebar & submenu -->
<script>
    (function () {
        const body = document.body;
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const btnToggle = document.getElementById('btnToggleSidebar');
        const btnClose = document.getElementById('btnCloseSidebar');
        const root = document.documentElement; // Dapatkan elemen root

        function openMobile() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            body.classList.add('no-scroll');
        }
        function closeMobile() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            body.classList.remove('no-scroll');
        }

        btnToggle.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('show')) {
                    closeMobile();
                } else {
                    openMobile();
                }
            } else {
                root.classList.toggle('sidebar-collapsed');
            }
        });

        if (btnClose) btnClose.addEventListener('click', closeMobile);
        overlay.addEventListener('click', closeMobile);

        // Make chevron rotate when submenu open (bootstrap collapse events)
        document.querySelectorAll('.has-sub .submenu').forEach(function (submenu) {
            submenu.addEventListener('show.bs.collapse', function (e) {
                const parent = submenu.closest('.has-sub');
                parent.classList.add('open');
            });
            submenu.addEventListener('hide.bs.collapse', function (e) {
                const parent = submenu.closest('.has-sub');
                parent.classList.remove('open');
            });
        });

        // ensure submenu with class "show" has parent open style on load
        document.querySelectorAll('.has-sub').forEach(function (el) {
            if (el.querySelector('.submenu.show')) el.classList.add('open');
        });

        // optional: close mobile sidebar when resize to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeMobile();
                // Pastikan sidebar-collapsed dihapus jika beralih ke desktop
                root.classList.remove('sidebar-collapsed');
            } else {
                // Saat beralih ke mobile, pastikan sidebar-collapsed dihapus
                root.classList.remove('sidebar-collapsed');
            }
        });

    })();
</script>

</body>
</html>

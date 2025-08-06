<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
    <title><?= $this->renderSection('title') ?> - Perpustakaan</title>
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?= $this->renderSection('custom_css') ?>
</head>
<style>
    body {
        background: url("<?= base_url("assets/img/1.png") ?>") no-repeat center fixed;
        background-size: cover;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        filter: blur(5px);
        z-index: -1;
    }

    #layoutSidenav_content {
        background-color: rgba(255, 255, 255, 0.9);
        min-height: 100vh;
    }
            
    .custom-navbar {
        background-color: rgba(56, 93, 241, 1) !important;
    }
            
    .sb-sidenav-dark {
        background-color: rgba(33, 37, 41, 0.9) !important;
    }
</style>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark custom-navbar">
        <a class="navbar-brand ps-3" href="<?= base_url('dashboard') ?>"><img src="<?= base_url('assets/img/logo-berbudi.png') ?>" alt="SMK BERBUDI YOGYAKARTA" height="35" class="d-inline-block align-text-top">
      </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                </div>
        </form>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Data Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url('anggota') ?>">Data Anggota</a>
                                <a class="nav-link" href="<?= base_url('buku') ?>">Data Buku</a>
                                <a class="nav-link" href="<?= base_url('kategori') ?>">Data Kategori</a>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Transaksi</div>
                        <a class="nav-link" href="<?= base_url('peminjaman') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-undo"></i></div>
                            Peminjaman / pengembalian
                        </a>
                        <a class="nav-link" href="<?= base_url('absensi') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                            Absensi Pengunjung
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Administrator
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $this->renderSection('page_title') ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $this->renderSection('breadcrumb') ?></li>
                    </ol>
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; smkberbudi 2025</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <?= $this->renderSection('custom_js') ?>
</body>
</html>
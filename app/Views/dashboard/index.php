<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('custom_css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashbaoard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Bagian Kartu Selamat Datang yang diperbarui -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-9">
                <h4 class="fw-bold">Selamat Datang Pustakawan SMK Berbudi!</h4>
                <p class="text-muted">Pantau perkembangan perpustakaan sekolah dengan mudah.</p>
                <a href="#!" class="btn btn-sm btn-primary mt-2">Lihat Laporan Lengkap</a>
            </div>
            <div class="col-md-3 text-center d-none d-md-block">
                <img src="https://placehold.co/120x120/E0F7FA/00796B?text=Ilustrasi" alt="Ilustrasi" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Kartu Total Anggota -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <a href="<?= base_url('anggota') ?>" class="text-decoration-none"><span class="text-muted fw-bold">Total Anggota</span></a>
                        <h4 class="mb-0 mt-1">4,800</h4>
                    </div>
                    <div class="icon-circle bg-light-primary">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kartu Total Buku -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <a href="<?= base_url('buku') ?>" class="text-decoration-none"><span class="text-muted fw-bold">Total Buku</span></a>
                        <h4 class="mb-0 mt-1">1,250</h4>
                    </div>
                    <div class="icon-circle bg-light-success">
                        <i class="fas fa-book-open text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kartu Buku Dipinjam -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <a href="<?= base_url('peminjaman') ?>" class="text-decoration-none"><span class="text-muted fw-bold">Buku Dipinjam</span></a>
                        <h4 class="mb-0 mt-1">75</h4>
                    </div>
                    <div class="icon-circle bg-light-info">
                        <i class="fas fa-handshake text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kartu Buku Terlambat -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <a href="<?= base_url('peminjaman') ?>"><span class="text-muted fw-bold">Buku Terlambat</span></a>
                        <h4 class="mb-0 mt-1">10</h4>
                    </div>
                    <div class="icon-circle bg-light-danger">
                        <i class="fas fa-clock text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling untuk card ringkasan data yang baru */
.card {
  border-radius: 0.5rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.icon-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
}

.bg-light-primary {
  background-color: #e6f2ff !important;
}
.bg-light-success {
  background-color: #d1f7e9 !important;
}
.bg-light-info {
  background-color: #e1f5fe !important;
}
.bg-light-danger {
  background-color: #ffe6e6 !important;
}

.text-primary {
  color: #0d6efd !important;
}
.text-success {
  color: #28a745 !important;
}
.text-info {
  color: #17a2b8 !important;
}
.text-danger {
  color: #dc3545 !important;
}

</style>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/demo/chart-area-demo.js') ?>"></script>
<script src="<?= base_url('assets/demo/chart-bar-demo.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

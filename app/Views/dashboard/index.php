<?= $this->extend('layouts/sb_admin') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-img">
    <img src="<?= base_url('assets/img/1.png') ?>" class="img-fluid" alt="img content">
</div>
<div class="card text-center">
    <div class="card-header">
        <h1 class="card-title">Selamat Datang</h1>
        <h1 class="card-title">Pustakawan</h1>
        <h1 class="card-title">SMK Berbudi</h1>
    </div>
<div class="card mb-4">
    <div class="card text-center">
    <div class="card-body">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="<?= base_url('assets/img/bg_latar.jpg') ?>" class="d-block w-100" alt="slide 1">
            </div>
            <div class="carousel-item">
            <img src="<?= base_url('assets/img/1.png') ?>" class="d-block w-100" alt="slide 2">
            </div>
            <div class="carousel-item">
            <img src="<?= base_url('assets/img/latar.jpg') ?>" class="d-block w-100" alt="slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    </div>
</div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Anggota</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('anggota') ?>">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Buku</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('buku') ?>">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Buku Dipinjam</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('peminjaman') ?>">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary  text-white mb-4">
            <div class="card-body">Buku Terlambat</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#!">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/demo/chart-area-demo.js') ?>"></script>
<script src="<?= base_url('assets/demo/chart-bar-demo.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>
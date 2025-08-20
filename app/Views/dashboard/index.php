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

<?= $this->section('content') ?>

<div class="main-content">
    <canvas id="rain"></canvas>
    <div class="content-rain">

        
<h1 class="text-center" id="typewritter" style="font-family: sans-serif;color:#0d6efd;text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">Selamat Datang Pustakawan SMK Berbudi</h1>

<br>
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
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script>
const text = "Selamat Datang Pustakawan SMK Berbudi";
const element = document.getElementById("typewritter");
const typingSpeed = 150; 
const erasingSpeed = 100; 
const delayAfterTyping = 1500; 
const delayAfterErasing = 500; 

let index = 0;
let isDeleting = false;

function type() {
    if (!isDeleting) {
        element.textContent = text.substring(0, index + 1);
        index++;
        if (index === text.length) {
            
            setTimeout(() => {
                isDeleting = true;
                type();
            }, delayAfterTyping);
            return;
        }
        setTimeout(type, typingSpeed);
    } else {
        element.textContent = text.substring(0, index - 1);
        index--;
        if (index === 0) {
            
            setTimeout(() => {
                isDeleting = false;
                type();
            }, delayAfterErasing);
            return;
        }
        setTimeout(type, erasingSpeed);
    }
}

type();

</script>
<?= $this->endSection() ?>
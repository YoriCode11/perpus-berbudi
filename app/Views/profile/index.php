<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Profil
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
Profil
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card shadow-lg border-0 rounded-lg mt-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-user-circle me-2"></i> Profil Pengguna
    </div>
    
    <div class="card-body text-center">

        <?php 
        $profilePic = isset($user['gambar']) ? $user['gambar'] : 'logo.png';
        ?>
        <div class="mb-3">
            <img src="<?= base_url('uploads/' . $profilePic) ?>" 
                 alt="Foto Profil" 
                 class="rounded-circle shadow-sm mb-3"
                 style="width:120px; height:120px; object-fit:cover;">
        </div>

        <!-- Info User -->
        <h5 class="card-title mb-3"> <?= esc(is_array($user) ? $user['username'] : $user->username) ?></h5>
        <p class="mb-2"><strong>Email       :</strong> <?= esc($user['email']) ?></p>
        <p class="mb-2"><strong>Role        :</strong> <?= esc($user['role']) ?></p>
        <p class="mb-2"><strong>Nama Lengkap:</strong> <?= esc($user['fullname']) ?></p>
    </div>
    <div class="card-footer text-center d-flex justify-content-center gap-2">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i> Edit Profil
        </a>
        <a href="<?= base_url('profile/change-password') ?>" class="btn btn-warning btn-sm text-white">
            <i class="fas fa-key"></i> Ganti Password
        </a>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>

<?= $this->endSection() ?>

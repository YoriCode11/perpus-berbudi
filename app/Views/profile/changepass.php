<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Edit Profil
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Edit Profil
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
Profil
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<form id="changePasswordForm" action="<?= base_url('profile/changePassword')?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Foto Profil -->
    <div class="text-center mb-3">
        <img src="<?= base_url('uploads/' . ($user['gambar'] ?? 'logo.png')) ?>" class="rounded-circle" width="120" height="120" alt="Foto Profil">
    </div>

    <div class="mb-3">
        <label for="current_password" class="form-label">Password Lama</label>
        <div class="input-group">
            <input type="password" class="form-control rounded-2" id="current_password" name="current_password" required>
            <button class="btn btn-outline-secondary rounded-2 ms-2 togglePassword" type="button" id="togglePassword">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>
        <small class="error-message text-danger"></small>
    </div>

    <div class="mb-3">
        <label for="new_password" class="form-label">Password Baru</label>
        <div class="input-group">
            <input type="password" class="form-control rounded-2" id="new_password" name="new_password" required>
            <button class="btn btn-outline-secondary rounded-2 ms-2 togglePassword" type="button" id="togglePassword">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>
        <small class="error-message text-danger"></small>
    </div>

    <div class="mb-3">
        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
        <div class="input-group">
            <input type="password" class="form-control rounded-2" id="confirm_password" name="confirm_password" required>
            <button class="btn btn-outline-secondary rounded-2 ms-2 togglePassword" type="button"  id="togglePassword">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>
        <small class="error-message text-danger"></small>
    </div>

    <div class="d-flex justify-content-center gap-2 mt-4">
        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script>
    const togglePasswordButtons = document.querySelectorAll('.togglePassword');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
            const input = this.previousElementSibling; // input password sebelum tombol
            const icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });
    });
</script>
<?= $this->endSection() ?>

 

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

        <form action="<?= base_url('profile/update')?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Foto Profil -->
            <div class="text-center mb-3">
                <img src="<?= base_url('uploads/' . ($user['gambar'] ?? 'logo.png')) ?>" class="rounded-circle" width="120" height="120" alt="Foto Profil">
                <div class="mt-2">
                    <input type="file" name="gambar" class="form-control form-control-sm">
                </div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" value="<?= esc($user['username']) ?>" required />
                <label for="inputUsername">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputFullName" name="fullname" type="text" placeholder="Nama Lengkap" value="<?= esc($user['fullname']) ?>" required />
                <label for="inputFullname">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Email" value="<?= esc($user['email']) ?>" required />
                <label for="inputEmail">Email</label>
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
    </div>
</div>
<?= $this->endSection() ?>
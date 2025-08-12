<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<?= $breadcrumb ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user-plus me-1"></i>
        <?= $page_title ?>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php
            $action_url = isset($anggota) ? base_url('anggota/update/' . $anggota['id']) : base_url('anggota/store');
            $form_method = isset($anggota) ? 'PUT' : 'POST';
        ?>
        <form action="<?= $action_url ?>" method="post">
            <?= csrf_field() ?>
            <?php if (isset($anggota)): ?>
                <input type="hidden" name="_method" value="<?= $form_method ?>">
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : '' ?>" id="inputNama" name="nama" type="text" placeholder="Nama Anggota" value="<?= old('nama', isset($anggota) ? $anggota['nama'] : '') ?>" required />
                <label for="inputNama">Nama Anggota</label>
                <?php if (session('validation') && session('validation')->hasError('nama')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('nama') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control <?= (session('validation') && session('validation')->hasError('no_telp')) ? 'is-invalid' : '' ?>" id="inputNoTelp" name="no_telp" type="text" placeholder="No. Telepon" value="<?= old('no_telp', isset($anggota) ? $anggota['no_telp'] : '') ?>" required />
                <label for="inputNoTelp">No. Telepon</label>
                <?php if (session('validation') && session('validation')->hasError('no_telp')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('no_telp') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control <?= (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : '' ?>" id="inputEmail" name="email" type="email" placeholder="Email" value="<?= old('email', isset($anggota) ? $anggota['email'] : '') ?>" />
                <label for="inputEmail">Email (Opsional)</label>
                <?php if (session('validation') && session('validation')->hasError('email')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('email') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select <?= (session('validation') && session('validation')->hasError('jurusan')) ? 'is-invalid' : '' ?>" id="inputJurusan" name="jurusan" aria-label="Pilih Jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="DKV/Multimedia" <?= (old('jurusan', isset($anggota) ? $anggota['jurusan'] : '') == 'DKV/Multimedia') ? 'selected' : '' ?>>DKV/Multimedia</option>
                    <option value="Kuliner" <?= (old('jurusan', isset($anggota) ? $anggota['jurusan'] : '') == 'Kuliner') ? 'selected' : '' ?>>Kuliner</option>
                    <option value="Kecantikan" <?= (old('jurusan', isset($anggota) ? $anggota['jurusan'] : '') == 'Kecantikan') ? 'selected' : '' ?>>Kecantikan</option>
                </select>
                <label for="inputJurusan">Jurusan</label>
                <?php if (session('validation') && session('validation')->hasError('jurusan')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('jurusan') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="btn btn-secondary" href="<?= base_url('anggota') ?>">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

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
        <i class="fas fa-plus me-1"></i>
        <?= $page_title ?>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php
            // Untuk operasi store, resource routing akan mengarah ke base_url('kategori') dengan method POST
            // Untuk operasi update, akan mengarah ke base_url('kategori/ID') dengan method PUT
            $action_url = isset($kategori) ? base_url('kategori/' . $kategori['id']) : base_url('kategori'); // PERUBAHAN: 'kategori/update/ID' menjadi 'kategori/ID', dan 'kategori/store' menjadi 'kategori'
            $form_method = isset($kategori) ? 'PUT' : 'POST';
        ?>
        <form action="<?= $action_url ?>" method="post">
            <?= csrf_field() ?>
            <?php if (isset($kategori)): ?>
                <input type="hidden" name="_method" value="<?= $form_method ?>">
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input class="form-control <?= (session('validation') && session('validation')->hasError('nama_kategori')) ? 'is-invalid' : '' ?>" id="inputNamaKategori" name="nama_kategori" type="text" placeholder="Nama Kategori" value="<?= old('nama_kategori', isset($kategori) ? $kategori['nama_kategori'] : '') ?>" required />
                <label for="inputNamaKategori">Nama Kategori</label>
                <?php if (session('validation') && session('validation')->hasError('nama_kategori')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('nama_kategori') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="btn btn-secondary" href="<?= base_url('kategori') ?>">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

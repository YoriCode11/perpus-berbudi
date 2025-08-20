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
<div class="card shadow-lg border-0 rounded-3 mb-4">

    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="fas fa-book-medical me-2"></i>
        <h5 class="mb-0"><?= $page_title ?></h5>
    </div>


    <div class="card-body p-4">
        <form action="<?= base_url('/kategori/store') ?>" method="post">
            <?= csrf_field() ?>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputName" name="name" type="text" placeholder="Nama Kategori" value="<?= old('name', $category['name']) ?>" required />
                <label for="inputName">Nama Kategori</label>
            </div>


            <div class="form-floating mb-3">
                <textarea class="form-control" id="inputDescription" name="description" placeholder="Deskripsi Kategori" style="height: 100px;"><?= old('description', $category['description']) ?></textarea>
                <label for="inputDescription">Deskripsi</label>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-outline-danger px-4" href="<?= base_url('kategori') ?>">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button class="btn btn-primary px-4" type="submit">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>

<?= $this->endSection() ?>


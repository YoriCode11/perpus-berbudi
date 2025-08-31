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
        <form action="<?= base_url('/buku/store') ?>" method="post">
            <?= csrf_field() ?>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputLocation" name="location" type="text" placeholder="Letak Buku" required />
                <label for="inputLocation">rak</label>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputTitle" name="title" type="text" placeholder="Judul Buku" required />
                <label for="inputTitle">Judul Buku</label>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputAuthor" name="author" type="text" placeholder="Penulis" required />
                <label for="inputAuthor">Penulis</label>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputPublisher" name="publisher" type="text" placeholder="Penerbit" required />
                <label for="inputPublisher">Penerbit</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputPublishYear" name="publish_year" type="number" placeholder="Tahun Terbit (YYYY)" required />
                <label for="inputPublishYear">Tahun Terbit</label>
            </div>


            <div class="form-floating mb-3">
                <select class="form-select" id="inputIdKategori" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $cat): ?>
                        <option value="<?= esc($cat['id']) ?>"
                            <?= (old('cetegory_id', isset($buku) ? $buku['category_id'] : '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="inputIdKategori">Kategori</label>
            </div>


            <div class="form-floating mb-4">
                <input class="form-control" id="inputStock" name="stock" type="number" placeholder="Stok" required min="0" />
                <label for="inputStock">Jumlah</label>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-outline-danger px-4" href="<?= base_url('buku') ?>">
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


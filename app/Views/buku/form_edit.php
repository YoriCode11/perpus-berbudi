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
    <div class="card-header bg-warning text-dark d-flex align-items-center">
        <i class="fas fa-edit me-2"></i>
        <h5 class="mb-0"><?= $page_title ?></h5>
    </div>
    <div class="card-body p-4">
        <form action="<?= base_url('/buku/update/' . $buku['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputLocation" name="location" type="text"
                    placeholder="Letak Buku" value="<?= old('location', $buku['location']) ?>" required />
                <label for="inputLocation">Letak Buku</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputTitle" name="title" type="text"
                    placeholder="Judul Buku" value="<?= old('title', $buku['title']) ?>" required />
                <label for="inputTitle">Judul Buku</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputAuthor" name="author" type="text"
                    placeholder="Penulis" value="<?= old('author', $buku['author']) ?>" required />
                <label for="inputAuthor">Penulis</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputPublisher" name="publisher" type="text"
                    placeholder="Penerbit" value="<?= old('publisher', $buku['publisher']) ?>" required />
                <label for="inputPublisher">Penerbit</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputPublishYear" name="publish_year" type="number"
                    placeholder="Tahun Terbit (YYYY)" value="<?= old('publish_year', $buku['publish_year']) ?>" required />
                <label for="inputPublishYear">Tahun Terbit</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="inputIdKategori" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $cat): ?>
                        <option value="<?= esc($cat['id']) ?>"
                            <?= (old('category_id', isset($buku) ? $buku['category_id'] : '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="inputIdKategori">Kategori</label>
            </div>
            <div class="form-floating mb-4">
                <input class="form-control" id="inputStock" name="stock" type="number"
                    placeholder="Stok" min="0" value="<?= old('stock', $buku['stock']) ?>" required />
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

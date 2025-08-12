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
        <i class="fas fa-book-medical me-1"></i>
        <?= $page_title ?>
    </div>
    <div class="card-body">
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
            // Perbaikan: Gunakan resource routing yang benar
            $action_url = isset($buku) ? base_url('buku/' . $buku['id']) : base_url('buku');
            $form_method = isset($buku) ? 'PUT' : 'POST';
        ?>
        <form action="<?= $action_url ?>" method="post">
            <?= csrf_field() ?>
            <?php if (isset($buku)): ?>
                <input type="hidden" name="_method" value="<?= $form_method ?>">
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputJudul" name="judul" type="text" placeholder="Judul Buku" value="<?= old('judul', isset($buku) ? $buku['judul'] : '') ?>" required />
                <label for="inputJudul">Judul Buku</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputPenulis" name="penulis" type="text" placeholder="Penulis" value="<?= old('penulis', isset($buku) ? $buku['penulis'] : '') ?>" required />
                <label for="inputPenulis">Penulis</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputPenerbit" name="penerbit" type="text" placeholder="Penerbit" value="<?= old('penerbit', isset($buku) ? $buku['penerbit'] : '') ?>" required />
                <label for="inputPenerbit">Penerbit</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputTahunTerbit" name="tahun_terbit" type="number" placeholder="Tahun Terbit (YYYY)" value="<?= old('tahun_terbit', isset($buku) ? $buku['tahun_terbit'] : '') ?>" required />
                <label for="inputTahunTerbit">Tahun Terbit</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="inputIdKategori" name="id_kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $cat): ?>
                        <option value="<?= esc($cat['id']) ?>"
                            <?= (old('id_kategori', isset($buku) ? $buku['id_kategori'] : '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="inputIdKategori">Kategori</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputStok" name="stok" type="number" placeholder="Stok" value="<?= old('stok', isset($buku) ? $buku['stok'] : '') ?>" required min="0" />
                <label for="inputStok">Stok</label>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="btn btn-secondary" href="<?= base_url('buku') ?>">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

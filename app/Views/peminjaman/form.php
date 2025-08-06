<?= $this->extend('layouts/sb_admin') ?>

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
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('peminjaman/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-floating mb-3">
                <select class="form-select" id="inputIdAnggota" name="id_anggota" required>
                    <option value="">Pilih Anggota</option>
                    <?php foreach ($anggota as $agt): ?>
                        <option value="<?= esc($agt['id']) ?>"
                            <?= (old('id_anggota') == $agt['id']) ? 'selected' : '' ?>>
                            <?= esc($agt['nama']) ?> (<?= esc($agt['no_telp']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="inputIdAnggota">Anggota Peminjam</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="inputIdBuku" name="id_buku" required>
                    <option value="">Pilih Buku (Stok Tersedia)</option>
                    <?php foreach ($buku as $bk): ?>
                        <option value="<?= esc($bk['id']) ?>"
                            <?= (old('id_buku') == $bk['id']) ? 'selected' : '' ?>>
                            <?= esc($bk['judul']) ?> (Stok: <?= esc($bk['stok']) ?>)
                        </option>
                    <?php endforeach; ?>
                    <?php if (empty($buku)): ?>
                        <option value="" disabled>Tidak ada buku tersedia</option>
                    <?php endif; ?>
                </select>
                <label for="inputIdBuku">Buku yang Dipinjam</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="inputTanggalPinjam" type="text" value="<?= date('d-m-Y H:i') ?>" disabled />
                <label for="inputTanggalPinjam">Tanggal Pinjam</label>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="btn btn-secondary" href="<?= base_url('peminjaman') ?>">Batal</a>
                <button class="btn btn-primary" type="submit">Catat Peminjaman</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
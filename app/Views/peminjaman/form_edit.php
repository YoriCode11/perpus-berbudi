
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
        <i class="fas fa-book-medical me-2"></i>
        <h5 class="mb-0"><?= $page_title ?></h5>
    </div>
    <div class="card-body p-4">
        <form action="<?= base_url('/peminjaman/update/' . $peminjaman['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama Anggota</label>
                <select name="member_id" class="form-control" required>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= $peminjaman['member_id']==$m['id'] ? 'selected':'' ?>>
                            <?= esc($m['name']) ?> (<?= esc($m['nis']) ?>)
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <select name="book_id" class="form-control" required>
                    <?php foreach ($books as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= $peminjaman['book_id']==$b['id'] ? 'selected':'' ?>>
                            <?= esc($b['title']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Buku</label>
                <input type="number" name="qty" class="form-control" 
                       value="<?= $peminjaman['qty'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" class="form-control" 
                       value="<?= $peminjaman['borrow_date'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="return_date" class="form-control" 
                       value="<?= $peminjaman['return_date'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Dipinjam" <?= $peminjaman['status']=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
                    <option value="Dikembalikan" <?= $peminjaman['status']=='Dikembalikan'?'selected':'' ?>>Dikembalikan</option>
                    <option value="Terlambat" <?= $peminjaman['status']=='Terlambat'?'selected':'' ?>>Terlambat</option>
                </select>
            </div>

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


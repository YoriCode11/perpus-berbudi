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
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <i class="fas fa-edit me-2"></i> <?= $page_title ?>
    </div>
    <div class="card-body">
        <form action="<?= base_url('peminjaman/update/'.$peminjaman['id']) ?>" method="post">
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

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

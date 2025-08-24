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
        <i class="fas fa-book me-1"></i>
        Daftar Peminjaman
        <a href="<?= base_url('peminjaman/new') ?>" class="btn btn-primary btn-sm float-end">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>
    <div class="card-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($peminjaman as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['member_name']) ?> (<?= esc($row['member_nis']) ?>)</td>
                        <td><?= esc($row['book_title']) ?></td>
                        <td><?= esc($row['qty']) ?></td>
                        <td><?= esc($row['borrow_date']) ?></td>
                        <td><?= $row['return_date'] ? esc($row['return_date']) : '-' ?></td>
                        <td>
                            <?php if ($row['status'] == 'Dipinjam'): ?>
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            <?php elseif ($row['status'] == 'Dikembalikan'): ?>
                                <span class="badge bg-success">Dikembalikan</span>
                            <?php elseif ($row['status'] == 'Terlambat'): ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('peminjaman/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('peminjaman/' . $row['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script src="<?= base_url('assets/js/datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/datatables.min.js') ?>"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#myTable').DataTable({
        scrollY: true,
        autoWidth: false,
        responsive: true
    });
});
</script>
<?= $this->endSection() ?>

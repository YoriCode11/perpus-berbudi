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
        <i class="fas fa-calendar-check me-1"></i>
        Daftar Absensi
        <a href="<?= base_url('absensi/new') ?>" class="btn btn-primary btn-sm float-end">
            <i class="fas fa-plus"></i> Tambah Absensi
        </a>
    </div>
    <div class="card-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>NIS</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($attendances as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['member_name']) ?></td>
                        <td><?= esc($row['member_nis']) ?></td>
                        <td><?= esc($row['date']) ?></td>
                        <td><?= esc($row['status']) ?></td>
                        <td><?= esc($row['time_in']) ?: '-' ?></td>
                        <td><?= esc($row['time_out']) ?: '-' ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('absensi/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('absensi/' . $row['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus absensi ini?');">
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
        responsive: false
    });
});
</script>
<?= $this->endSection() ?>

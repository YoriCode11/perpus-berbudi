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
        <i class="fas fa-person me-1"></i>
        Daftar Anggota
        <a href="<?= base_url('anggota/new') ?>" class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Tambah Anggota</a>
    </div>
    <div class="card-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nis</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>No Telp</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($members as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['name']) ?></td>
                        <td><?= esc($row['nis']) ?></td>
                        <td><?= esc($row['class']) ?></td>
                        <td><?= esc($row['major']) ?></td>
                        <td><?= esc($row['phone']) ?></td>
                        <td><?= esc($row['status']) ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('anggota/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="<?= base_url('anggota/' . $row['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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

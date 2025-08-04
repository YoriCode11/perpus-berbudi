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
        <i class="fas fa-book me-1"></i>
        Daftar Buku
        <a href="<?= base_url('buku/new') ?>" class="btn btn-primary btn-sm float-end">Tambah Buku</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($buku as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['judul']) ?></td>
                        <td><?= esc($row['penulis']) ?></td>
                        <td><?= esc($row['penerbit']) ?></td>
                        <td><?= esc($row['tahun_terbit']) ?></td>
                        <td><?= esc($row['nama_kategori']) ?></td>
                        <td><?= esc($row['stok']) ?></td>
                        <td>
                            <a href="<?= base_url('buku/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= base_url('buku/' . $row['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

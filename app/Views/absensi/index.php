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
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Absensi Pengunjung
            <a href="<?= base_url('absensi/new') ?>" class="btn btn-primary btn-sm float-end">Catat Absensi Baru</a> <!-- PERUBAHAN DI SINI: 'create' menjadi 'new' -->
        </div>
        <div class="card-body">
            <?= session()->getFlashdata('success') ? '<div class="alert alert-success">' . session()->getFlashdata('success') . '</div>' : '' ?>
            <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>' : '' ?>
            <?= session()->getFlashdata('info') ? '<div class="alert alert-info">' . session()->getFlashdata('info') . '</div>' : '' ?>


            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($absensi as $row) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= esc($row['nama_anggota']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                            <td><?= date('H:i:s', strtotime($row['tanggal_masuk'])) ?></td>
                            <td><?= $row['tanggal_keluar'] ? date('H:i:s', strtotime($row['tanggal_keluar'])) : '-' ?></td>
                            <td>
                                <?php if ($row['status'] == 'masuk') : ?>
                                    <span class="badge bg-success">Masuk</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Keluar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'masuk') : ?>
                                    <a href="<?= base_url('absensi/checkout/' . $row['id']) ?>" class="btn btn-info btn-sm" onclick="return confirm('Konfirmasi checkout anggota ini?');">Checkout</a>
                                <?php else : ?>
                                    <button class="btn btn-secondary btn-sm" disabled>Sudah Checkout</button>
                                <?php endif; ?>
                                <form action="<?= base_url('absensi/' . $row['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan absensi ini?');">
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
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/datatables-simple-demo.js') ?>"></script>
<?= $this->endSection() ?>

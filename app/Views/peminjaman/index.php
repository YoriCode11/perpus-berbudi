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
        <i class="fas fa-undo"></i>
        Daftar Peminjaman
        <a href="<?= base_url('peminjaman/new') ?>" class="btn btn-primary btn-sm float-end">Catat Peminjaman Baru</a> <!-- PERUBAHAN DI SINI: 'create' menjadi 'new' -->
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
        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info" role="alert">
                <?= session()->getFlashdata('info') ?>
            </div>
        <?php endif; ?>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($peminjaman as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['nama_anggota']) ?></td>
                        <td><?= esc($row['judul_buku']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime(esc($row['tanggal_pinjam']))) ?></td>
                        <td>
                            <?php if (!empty($row['tanggal_kembali'])): ?>
                                <?= date('d-m-Y H:i', strtotime(esc($row['tanggal_kembali']))) ?>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Belum Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'dipinjam'): ?>
                                <span class="badge bg-danger">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge bg-success">Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'dipinjam'): ?>
                                <a href="<?= base_url('peminjaman/kembalikan/' . $row['id']) ?>" class="btn btn-info btn-sm" onclick="return confirm('Konfirmasi pengembalian buku ini?');">Kembalikan</a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Sudah Kembali</button>
                            <?php endif; ?>
                            <form action="<?= base_url('peminjaman/' . $row['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan peminjaman ini?');">
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

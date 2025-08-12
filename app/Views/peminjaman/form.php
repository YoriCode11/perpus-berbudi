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
        <i class="fas fa-plus-circle me-1"></i>
        Form Catat Peminjaman
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info" role="alert">
                <?= session()->getFlashdata('info') ?>
            </div>
        <?php endif; ?>

        <?php
            // Action URL untuk form:
            // Jika ada objek 'peminjaman' (mode edit), arahkan ke peminjaman/ID dengan method PUT
            // Jika tidak (mode tambah), arahkan ke peminjaman dengan method POST
            $action_url = isset($peminjaman) ? base_url('peminjaman/' . $peminjaman['id']) : base_url('peminjaman');
            $form_method = isset($peminjaman) ? 'PUT' : 'POST';
        ?>
        <form action="<?= $action_url ?>" method="post">
            <?= csrf_field() ?>
            <?php if (isset($peminjaman)): ?>
                <input type="hidden" name="_method" value="<?= $form_method ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="id_anggota" class="form-label">Pilih Anggota</label>
                <select class="form-select <?= (session('validation') && session('validation')->hasError('id_anggota')) ? 'is-invalid' : '' ?>" id="id_anggota" name="id_anggota" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($anggota as $a) : ?>
                        <option value="<?= $a['id'] ?>"
                            <?= (old('id_anggota', isset($peminjaman) ? $peminjaman['id_anggota'] : '') == $a['id']) ? 'selected' : '' ?>>
                            <?= esc($a['nama']) ?> (<?= esc($a['no_telp']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('validation') && session('validation')->hasError('id_anggota')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('id_anggota') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="id_buku" class="form-label">Pilih Buku</label>
                <select class="form-select <?= (session('validation') && session('validation')->hasError('id_buku')) ? 'is-invalid' : '' ?>" id="id_buku" name="id_buku" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($buku as $b) : ?>
                        <option value="<?= $b['id'] ?>"
                            <?= (old('id_buku', isset($peminjaman) ? $peminjaman['id_buku'] : '') == $b['id']) ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?> (Stok: <?= esc($b['stok']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('validation') && session('validation')->hasError('id_buku')) : ?>
                    <div class="invalid-feedback">
                        <?= session('validation')->getError('id_buku') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tanggal Pinjam dan Tanggal Kembali biasanya diisi otomatis atau disembunyikan untuk form tambah -->
            <!-- Jika Anda ingin input manual, Anda bisa tambahkan di sini -->
            <?php if (isset($peminjaman)): // Hanya tampilkan ini jika dalam mode edit ?>
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="datetime-local" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                           value="<?= old('tanggal_pinjam', isset($peminjaman) ? date('Y-m-d\TH:i', strtotime($peminjaman['tanggal_pinjam'])) : '') ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('tanggal_pinjam')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('tanggal_pinjam') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="datetime-local" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                           value="<?= old('tanggal_kembali', isset($peminjaman) && !empty($peminjaman['tanggal_kembali']) ? date('Y-m-d\TH:i', strtotime($peminjaman['tanggal_kembali'])) : '') ?>">
                    <?php if (session('validation') && session('validation')->hasError('tanggal_kembali')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('tanggal_kembali') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="dipinjam" <?= (old('status', isset($peminjaman) ? $peminjaman['status'] : '') == 'dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
                        <option value="kembali" <?= (old('status', isset($peminjaman) ? $peminjaman['status'] : '') == 'kembali') ? 'selected' : '' ?>>Kembali</option>
                    </select>
                    <?php if (session('validation') && session('validation')->hasError('status')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('status') ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

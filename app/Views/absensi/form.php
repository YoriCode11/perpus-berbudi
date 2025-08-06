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
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Form Catat Absensi Masuk
        </div>
        <div class="card-body">
            <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>' : '' ?>
            <?= session()->getFlashdata('success') ? '<div class="alert alert-success">' . session()->getFlashdata('success') . '</div>' : '' ?>
            <?= session()->getFlashdata('info') ? '<div class="alert alert-info">' . session()->getFlashdata('info') . '</div>' : '' ?>

            <form action="<?= base_url('absensi') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="id_anggota" class="form-label">Pilih Anggota</label>
                    <select class="form-select <?= (session('validation') && session('validation')->hasError('id_anggota')) ? 'is-invalid' : '' ?>" id="id_anggota" name="id_anggota">
                        <option value="">-- Pilih Anggota --</option>
                        <?php foreach ($anggota as $a) : ?>
                            <option value="<?= $a['id'] ?>" <?= (old('id_anggota') == $a['id']) ? 'selected' : '' ?>>
                                <?= $a['nama'] ?> (<?= $a['no_telp'] ?>)
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
                    <label for="tanggal_masuk_date" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control <?= (session('validation') && session('validation')->hasError('tanggal_masuk_date')) ? 'is-invalid' : '' ?>" id="tanggal_masuk_date" name="tanggal_masuk_date" value="<?= old('tanggal_masuk_date', date('Y-m-d')) ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('tanggal_masuk_date')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('tanggal_masuk_date') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="tanggal_masuk_time" class="form-label">Jam Masuk</label>
                    <input type="time" class="form-control <?= (session('validation') && session('validation')->hasError('tanggal_masuk_time')) ? 'is-invalid' : '' ?>" id="tanggal_masuk_time" name="tanggal_masuk_time" value="<?= old('tanggal_masuk_time', date('H:i')) ?>" required>
                    <?php if (session('validation') && session('validation')->hasError('tanggal_masuk_time')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('tanggal_masuk_time') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Catat Masuk</button>
                <a href="<?= base_url('absensi') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

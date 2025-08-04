<?= $this->extend('layouts/sb_admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $page_title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('absensi') ?>">Absensi</a></li>
        <li class="breadcrumb-item active"><?= $breadcrumb ?></li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Form Catat Absensi Masuk
        </div>
        <div class="card-body">
            <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>' : '' ?>

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
                <button type="submit" class="btn btn-primary">Catat Masuk</button>
                <a href="<?= base_url('absensi') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
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
<div class="card shadow-lg border-0 rounded-3 mb-4">

    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="fas fa-book-medical me-2"></i>
        <h5 class="mb-0"><?= $page_title ?></h5>
    </div>


    <div class="card-body p-4">
        <form action="<?= base_url('/anggota/store') ?>" method="post">
            <?= csrf_field() ?>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputName" name="name" type="text" placeholder="Nama Anggota" required />
                <label for="inputName">Nama Anggota</label>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputNis" name="nis" type="number" placeholder="Nis Anggota" required />
                <label for="inputNis">Nis Anggota</label>
            </div>


            <div class="form-floating mb-3">
                <select id="class" name="class" class="form-select" required>
                        <option value="">--Pilih Kelas--</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                </select>
                 <label for="class" class="form-label">Kelas</label>
            </div>

            <div class="form-floating mb-3">
                
                <select id="major" name="major" class="form-select" required>
                        <option value="">--Pilih Jurusan--</option>
                        <option value="Kecantikan">Kecantikan</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="DKV">DKV</option>
                </select>
                <label for="major" class="form-label">Jurusan</label>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="inputPhone" name="phone" type="number" placeholder="Nomor HP" required />
                <label for="inputPhone">Nomor HP</label>
            </div>

            <div class="form-floating mb-3">  
                <select id="status" name="status" class="form-select" required>
                        <option value="">--Pilih Status--</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>

                </select>
                <label for="status" class="form-label">Status</label>
            </div>


            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-outline-danger px-4" href="<?= base_url('buku') ?>">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button class="btn btn-primary px-4" type="submit">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>

<?= $this->endSection() ?>


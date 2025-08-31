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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="card shadow-lg border-0 rounded-3 mb-4">
    <div class="card-header bg-warning text-dark d-flex align-items-center">
        <i class="fas fa-book-medical me-2"></i>
        <h5 class="mb-0"><?= $page_title ?></h5>
    </div>
    
    <div class="card-body p-4">
        <form action="<?= base_url('/absensi/update/' . $attendance['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="member_id" class="form-label">Nama Anggota</label>
                <select name="member_id" id="member_id" class="form-control" data-placeholder="-- Pilih Anggota --" required>
                    <option></option> <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= (isset($attendance) && $attendance['member_id'] == $m['id']) ? 'selected' : '' ?>>
                            <?= esc($m['name']) ?> (<?= esc($m['nis']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control"
                    value="<?= isset($attendance) ? $attendance['date'] : old('date') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Hadir" <?= (isset($attendance) && $attendance['status'] == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
                    <option value="Tidak Hadir" <?= (isset($attendance) && $attendance['status'] == 'Tidak Hadir') ? 'selected' : '' ?>>Tidak Hadir</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="time_in" class="form-label">Jam Masuk</label>
                <input type="time" name="time_in" id="time_in" class="form-control"
                    value="<?= isset($attendance) ? $attendance['time_in'] : old('time_in') ?>">
            </div>
            
            <div class="mb-3">
                <label for="time_out" class="form-label">Jam Keluar</label>
                <input type="time" name="time_out" id="time_out" class="form-control"
                    value="<?= isset($attendance) ? $attendance['time_out'] : old('time_out') ?>">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#member_id').select2({
            theme: 'bootstrap-5',
            allowClear: true,
            width: '100%'
        });
    });
</script>
<?= $this->endSection() ?>
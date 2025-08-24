<form action="<?= base_url('forgot-password') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Lanjut</button>
</form>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Perpustakaan</title>
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>" />
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Kolom Kiri: Form Login -->
            <div class="col-lg-4 col-md-12 d-flex flex-column justify-content-center align-items-center p-4 left-panel">
                <div class="login-form-container">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" class="login-logo mb-3">
                        <h4 class="text-secondary fw-bold">Sistem Informasi Perpustakaan</h4>
                        <p class="text-muted">SMK BERBUDI YOGYAKARTA</p>
                    </div>



                    <form action="<?= base_url('auth/login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control rounded-2" id="username" name="username" value="<?= old('username') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-2" id="password" name="password" required>
                                <button class="btn btn-outline-secondary rounded-2 ms-2" type="button" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-2 btn-login">Log In</button>
                        </div>
                        <div class="d-grid mt-4">
                            <a href="<?= base_url('/' . 'resetpassword')?>" style="text-decoration:none">Lupa Password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block right-panel">
                <img src="<?= base_url('assets/img/latar.jpg') ?>" alt="Gedung Sekolah" class="img-fluid hero-image">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/alert.js') ?>"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

    <?php if (session()->getFlashdata('error')): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error') ?>',
        });
    });
    </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('login_success')): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('login_success') ?>',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "<?= base_url('dashboard') ?>";
        });
    });
    </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2000,
            showConfirmButton: false
        });
    });
    </script>
    <?php endif; ?>
</body>
</html>

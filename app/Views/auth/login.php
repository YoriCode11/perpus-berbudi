<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
    <title>Login - Perpustakaan</title>
    <!-- Link ke file CSS terpisah -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>" />
</head>
<body>
    <div class="wrapper">
        <!-- Form action harus mengarah ke controller login Anda -->
        <form action="<?= base_url('login/auth') ?>" method="post">
            <?= csrf_field() ?>
            <h2>Login Form</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($validation)): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="input-field">
                <input type="email" name="email" value="<?= old('email') ?>" required />
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required />
                <label>Enter your password</label>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember" name="remember" />
                    <p>Remember me</p>
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>

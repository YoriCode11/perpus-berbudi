<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attempt()
    {
        $userModel = new UserModel();
        $user = $userModel->where('username', $this->request->getPost('username'))->first();

        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            session()->set('user', $user);
            session()->set('isLoggedIn', true);

            return redirect()->to('/auth/login')->with('login_success', 'Login berhasil, sebentar lagi masuk ke dashboard...');
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Berhasil logout');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        return redirect()->to('/security-question/'.$user['id']);
    }

    public function securityQuestion($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'User tidak valid');
        }

        return view('auth/security_question', ['user' => $user]);
    }

    public function processSecurityQuestion($id)
    {
        $answer = strtolower(trim($this->request->getPost('security_answer')));
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user || strtolower($user['security_answer']) !== $answer) {
            return redirect()->back()->with('error', 'Jawaban salah!');
        }

        // Jawaban benar → ke halaman reset password
        return redirect()->to('/reset-password/'.$user['id']);
    }

    public function resetPassword($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'User tidak valid');
        }

        return view('auth/reset_password', ['user' => $user]);
    }

    public function processResetPassword($id)
    {
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('password_confirm');

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Password tidak sama');
        }

        $userModel = new UserModel();
        $userModel->update($id, [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Password berhasil direset, silakan login.');
    }

}

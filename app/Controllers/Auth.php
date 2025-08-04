<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        // Jika user sudah login, redirect ke halaman dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login',
        ];
        return view('auth/login', $data);
    }

    public function processLogin()
    {
        // Logika untuk memproses form login akan ditambahkan di sini
        // Saat ini, kita hanya akan kembali ke halaman login
        if ($this->request->getPost()) {
            // Validasi dan otentikasi akan ditambahkan di sini
            session()->setFlashdata('error', 'Fitur login belum diimplementasikan.');
            return redirect()->to(base_url('login'));
        }

        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        // Cek apakah user sudah login, jika ya, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Register',
            'validation' => \Config\Services::validation(), // Untuk menampilkan error validasi
        ];
        return view('auth/register', $data);
    }

    public function processRegister()
    {
        $model = new UserModel();

        // Validasi input
        if (!$this->validate($model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        // Ambil data dari form
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => 'anggota', // Default role untuk registrasi
        ];

        // Simpan data ke database
        if ($model->save($data)) {
            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to(base_url('login'));
        } else {
            session()->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        // Logika untuk logout
        session()->remove(['isLoggedIn', 'userData']);
        session()->setFlashdata('success', 'Anda telah logout.');
        return redirect()->to(base_url('login'));
    }
}

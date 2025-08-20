<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); 
    }

    public function index()
    {
        $userId = session()->get('user');
        $user = $this->userModel->find($userId['id']);

        return view('profile/index', [
            'user' => $user,
            'page_title' => 'Profil Saya',
            'breadcrumb' => 'Profil',
        ]);
    }

    public function edit()
    {
        $userId = session()->get('user');
        $user = $this->userModel->find($userId['id']);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'User tidak ditemukan.');
        }

        return view('profile/edit', [
            'user' => $user,
            'page_title' => 'Profil Saya',
            'breadcrumb' => 'Profil / Edit',
        ]);
    }

    public function update()
    {
        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'User tidak ditemukan.');
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 50 karakter.'
                ]
            ],
            'fullname' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 50 karakter.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'gambar' => [
                'rules'  => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif]|max_size[gambar,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus jpg, jpeg, png, atau gif.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'email'    => $this->request->getPost('email'),
        ];

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['gambar'] = $newName;

            if (!empty($user['gambar']) && file_exists('uploads/' . $user['gambar'])) {
                unlink('uploads/' . $user['gambar']);
            }
        }

        $this->userModel->update($userId, $data);
        $userUpdated = $this->userModel->find($userId);
        session()->set('user', $userUpdated);

        return redirect()->to('profile')->with('success', 'Profile berhasil diperbarui.');
    }

    public function changepass()
    {
        $userId = session()->get('user');
        $user = $this->userModel->find($userId['id']);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'User tidak ditemukan.');
        }

        return view('profile/changepass', [
            'user' => $user,
            'page_title' => 'Ubah Kata Sandi',
            'breadcrumb' => 'Profil / Ubah Kata Sandi',
        ]);
    }

    public function changePassword()
    {
        $userId = session()->get('user')['id'];
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'User tidak ditemukan.');
        }

        // validasi input
        $validation = \Config\Services::validation();

        $validation->setRules([
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ], [
            'current_password' => [
                'required' => 'Password lama wajib diisi'
            ],
            'new_password' => [
                'required'   => 'Password baru wajib diisi',
                'min_length' => 'Password baru minimal 6 karakter'
            ],
            'confirm_password' => [
                'required' => 'Konfirmasi password wajib diisi',
                'matches'  => 'Konfirmasi password tidak sama dengan password baru'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // cek password lama
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password lama tidak sesuai');
        }

        // update password baru
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        $this->userModel->update($userId, ['password' => $newPassword]);

        return redirect()->to('/profile')->with('success', 'Password berhasil diperbarui.');
    }


}

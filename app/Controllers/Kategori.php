<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Kategori',
            'page_title' => 'Data Kategori',
            'breadcrumb' => 'Data Master / Kategori',
            'kategori'   => $this->kategoriModel->findAll(), // Mengambil semua data kategori
            'validation' => \Config\Services::validation(), // Untuk validasi
        ];
        return view('kategori/index', $data);
    }

    public function new()
    {
        $data = [
            'title'      => 'Tambah Kategori',
            'page_title' => 'Tambah Kategori',
            'breadcrumb' => 'Data Master / Kategori / Tambah',
            'validation' => \Config\Services::validation(),
        ];
        return view('kategori/form', $data);
    }

    public function create() // Ini adalah metode untuk menyimpan data (POST)
    {
        // Aturan validasi untuk penambahan baru, mengabaikan yang soft-deleted
        $rules = [
            'nama_kategori' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,deleted_at,NULL]',
        ];

        if (!$this->validate($rules, $this->kategoriModel->validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        session()->setFlashdata('success', 'Data kategori berhasil ditambahkan.');
        return redirect()->to(base_url('kategori'));
    }

    public function edit($id = null)
    {
        // PERUBAHAN DI SINI: Gunakan withDeleted() untuk memastikan kategori yang soft-deleted juga bisa diedit
        $kategori = $this->kategoriModel->withDeleted()->find($id);

        // Tambahkan logging untuk melihat data kategori yang ditemukan
        log_message('debug', 'Kategori data found for edit (ID: ' . $id . '): ' . json_encode($kategori));

        if (!$kategori) {
            throw new PageNotFoundException('Kategori tidak ditemukan: ' . $id);
        }

        $data = [
            'title'      => 'Edit Kategori',
            'page_title' => 'Edit Kategori',
            'breadcrumb' => 'Data Master / Kategori / Edit',
            'kategori'   => $kategori,
            'validation' => \Config\Services::validation(),
        ];
        return view('kategori/form', $data);
    }

    public function update($id = null)
    {
        // Mengatur aturan validasi secara eksplisit untuk update
        // Ini memastikan is_unique mengabaikan ID kategori yang sedang diedit
        // DAN mengabaikan record yang sudah di-soft-delete
        $rules = [
            'nama_kategori' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id,' . $id . ',deleted_at,NULL]',
        ];

        if (!$this->validate($rules, $this->kategoriModel->validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataToUpdate = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        try {
            $updated = $this->kategoriModel->update($id, $dataToUpdate);

            if ($updated) {
                if ($this->kategoriModel->db->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Data kategori berhasil diperbarui.');
                } else {
                    session()->setFlashdata('info', 'Tidak ada perubahan pada data kategori.');
                }
            } else {
                $errors = $this->kategoriModel->errors();
                if (!empty($errors)) {
                    $errorMessages = implode('<br>', $errors);
                    session()->setFlashdata('error', 'Gagal memperbarui data kategori: ' . $errorMessages);
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui data kategori. Mungkin ada masalah database yang tidak terdeteksi atau data tidak berubah.');
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat memperbarui data kategori: ' . $e->getMessage());
        }

        return redirect()->to(base_url('kategori'));
    }

    public function delete($id = null)
    {
        if ($this->kategoriModel->delete($id)) {
            session()->setFlashdata('success', 'Data kategori berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data kategori.');
        }
        return redirect()->to(base_url('kategori'));
    }
}

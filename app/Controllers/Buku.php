<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->kategoriModel = new KategoriModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Buku',
            'page_title' => 'Data Buku',
            'breadcrumb' => 'Data Master / Buku',
            'buku'       => $this->bukuModel->getBukuWithKategori(),
            'validation' => \Config\Services::validation(),
        ];
        return view('buku/index', $data);
    }

    // Mengubah nama metode dari 'create' menjadi 'new' sesuai konvensi resource
    public function new()
    {
        $data = [
            'title'      => 'Tambah Buku',
            'page_title' => 'Tambah Buku',
            'breadcrumb' => 'Data Master / Buku / Tambah',
            'validation' => \Config\Services::validation(),
            // Gunakan withDeleted() untuk memastikan kategori yang soft-deleted juga bisa dipilih
            'kategori'   => $this->kategoriModel->withDeleted()->findAll(),
        ];
        return view('buku/form', $data);
    }

    // Mengubah nama metode dari 'store' menjadi 'create' sesuai konvensi resource
    public function create()
    {
        // Perbaikan: Lakukan validasi dan tangani kegagalan
        if (!$this->validate($this->bukuModel->validationRules, $this->bukuModel->validationMessages)) {
            // Tambahkan logging untuk melihat kesalahan validasi secara detail
            log_message('error', 'Validation failed for adding a new book. Errors: ' . json_encode($this->validator->getErrors()));

            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->bukuModel->save([
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'stok'         => $this->request->getPost('stok'),
        ]);

        session()->setFlashdata('success', 'Data buku berhasil ditambahkan.');
        return redirect()->to(base_url('buku'));
    }

    public function edit($id = null)
    {
        // Gunakan withDeleted() untuk memastikan buku yang soft-deleted juga bisa diedit
        $buku = $this->bukuModel->withDeleted()->find($id);

        if (!$buku) {
            throw new PageNotFoundException('Buku tidak ditemukan: ' . $id);
        }

        $data = [
            'title'      => 'Edit Buku',
            'page_title' => 'Edit Buku',
            'breadcrumb' => 'Data Master / Buku / Edit',
            'buku'       => $buku,
            'validation' => \Config\Services::validation(),
            // Gunakan withDeleted() untuk memastikan kategori yang soft-deleted juga bisa dipilih
            'kategori'   => $this->kategoriModel->withDeleted()->findAll(),
        ];
        return view('buku/form', $data);
    }

    public function update($id = null)
    {
        // Validasi, pastikan menggunakan validationRules dari model
        if (!$this->validate($this->bukuModel->validationRules, $this->bukuModel->validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->bukuModel->update($id, [
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'stok'         => $this->request->getPost('stok'),
        ]);

        session()->setFlashdata('success', 'Data buku berhasil diperbarui.');
        return redirect()->to(base_url('buku'));
    }

    public function delete($id = null)
    {
        if ($this->bukuModel->delete($id)) {
            session()->setFlashdata('success', 'Data buku berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data buku.');
        }
        return redirect()->to(base_url('buku'));
    }
}

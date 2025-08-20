<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;

class Buku extends BaseController
{
    protected $bukuModel;

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
            'buku'       => $this->bukuModel->getBukuWithCategory(),
            'validation' => \Config\Services::validation(),
        ];
        return view('buku/index', $data);
    }

    public function new()
    {
        $data = [
            'title'      => 'Tambah Buku',
            'page_title' => 'Tambah Buku',
            'breadcrumb' => 'Data Master / Buku / Tambah',
            'kategori'   => $this->kategoriModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('buku/form', $data);
    }

 public function store()
{
    $data = $this->request->getPost();

    if (!$this->bukuModel->save($data)) {
        return redirect()->back()->withInput()->with('errors', $this->bukuModel->errors());
    }

    return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
}

    public function edit($id)
    {
        $book = $this->bukuModel->find($id);
        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku dengan ID $id tidak ditemukan");
        }

        $data = [
            'title'      => 'Edit Buku',
            'page_title' => 'Edit Buku',
            'breadcrumb' => 'Data Master / Buku / Edit',
            'kategori'   => $this->kategoriModel->findAll(),
            'buku'       => $book,
            'validation' => \Config\Services::validation(),
        ];

        return view('buku/form_edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if(!$this->bukuModel->update($id, $data)){
            return redirect()->back()->withInput()->with('errors', $this->bukuModel->errors());
        }
        return redirect()->to('/buku')->with('success', 'Buku berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus');
    }
}

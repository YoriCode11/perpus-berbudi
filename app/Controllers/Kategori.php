<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
            'page_title' => 'Kategori',
            'breadcrumb' => 'Data Master / Kategori',
            'category' => $this->kategoriModel->findAll()
        ];
        return view('kategori/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Kategori',
            'page_title' => 'Tambah Kategori',
            'breadcrumb' => 'Kategori / Tambah',
            'validation' => \Config\Services::validation(),
        ];
        return view('kategori/form', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (!$this->kategoriModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kategoriModel->errors());
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kategori',
            'page_title' => 'Edit Kategori',
            'breadcrumb' => 'Kategori / Edit',
            'category' => $kategori
        ];

        return view('kategori/form_edit', $data);
    }


public function update($id)
{
    $kategori = $this->kategoriModel->find($id);

    if (!$kategori) {
        return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
    }

    $data = $this->request->getPost();

    $this->kategoriModel->setValidationRules([
        'description' => 'required|min_length[3]',
        'name'  => 'required|min_length[3]|max_length[100]|is_unique[categories.name,id,' . $id . ']',

    ]);

    if (!$this->validate($this->kategoriModel->getValidationRules())) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->kategoriModel->update($id, $data);
    return redirect()->to('/kategori')->with('success', ' berhasil diperbarui.');
}
    
    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        session()->setFlashdata('success', 'Data kategori berhasil dihapus');
        return redirect()->to('/kategori');
    }
}
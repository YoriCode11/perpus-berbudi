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
            'breadcrumb' => 'Kategori',
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
        $category = $this->kategoriModel->find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $name = $this->request->getPost('name');


        if ($name != $category['name']) {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name]',
                'description' => 'required|min_length[3]',
            ];
        } else {

            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required|min_length[3]',
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->update($id, [
            'name' => $name,
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        session()->setFlashdata('success', 'Data kategori berhasil dihapus');
        return redirect()->to('/kategori');
    }
}
<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Anggota',
            'page_title' => 'Anggota',
            'breadcrumb' => 'Anggota',
            'members' => $this->anggotaModel->findAll()
        ];
        return view('anggota/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Anggota',
            'page_title' => 'Tambah Anggota',
            'breadcrumb' => 'Anggota / Tambah',
            'validation' => \Config\Services::validation(),
        ];
        return view('anggota/form', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (!$this->anggotaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->anggotaModel->errors());
        }

        return redirect()->to('/anggota')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anggota tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Anggota',
            'page_title' => 'Edit Anggota',
            'breadcrumb' => 'Anggota / Edit',
            'member' => $anggota
        ];

        return view('anggota/form_edit', $data);
    }

public function update($id)
{
    $category = $this->kategoriModel->find($id);

    if (!$category) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    }

    // Validasi input
    $rules = [
        'name' => [
            'label' => 'Nama Kategori',
            'rules' => "required|min_length[3]|max_length[100]|is_unique[categories.name,id,$id]",
            'errors' => [
                'required' => 'Nama kategori wajib diisi.',
                'min_length' => 'Nama kategori minimal 3 karakter.',
                'max_length' => 'Nama kategori maksimal 100 karakter.',
                'is_unique' => 'Nama kategori sudah digunakan.'
            ]
        ],
        'description' => [
            'label' => 'Deskripsi',
            'rules' => 'required|string|min_length[3]',
            'errors' => [
                'required' => 'Deskripsi wajib diisi.',
                'min_length' => 'Deskripsi minimal 3 karakter.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Update data
    $this->kategoriModel->update($id, [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description')
    ]);

    return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
}


    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        session()->setFlashdata('success', 'Data anggota berhasil dihapus');
        return redirect()->to('/anggota');
    }
}

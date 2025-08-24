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
            'breadcrumb' => 'Data Master / Anggota',
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
    $anggota = $this->anggotaModel->find($id);

    if (!$anggota) {
        return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
    }

    // Ambil data dari form
    $data = $this->request->getPost();

    // Set ID yang akan di-exclude dari is_unique
    $this->anggotaModel->setValidationRules([
        'name' => 'required|min_length[3]|max_length[100]',
        'nis'  => 'required|numeric|is_unique[members.nis,id,' . $id . ']',
        'class' => 'required',
        'major' => 'required',
        'phone' => 'required|numeric',
        'status'=> 'required'
    ]);

    if (!$this->validate($this->anggotaModel->getValidationRules())) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->anggotaModel->update($id, $data);
    return redirect()->to('/anggota')->with('success', 'Anggota berhasil diperbarui.');
}


    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        session()->setFlashdata('success', 'Data anggota berhasil dihapus');
        return redirect()->to('/anggota');
    }
}

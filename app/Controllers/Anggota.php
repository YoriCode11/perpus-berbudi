<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Anggota',
            'page_title' => 'Data Anggota',
            'breadcrumb' => 'Data Master / Anggota',
            'anggota'    => $this->anggotaModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('anggota/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Anggota',
            'page_title' => 'Tambah Anggota',
            'breadcrumb' => 'Data Master / Anggota / Tambah Anggota',
            'validation' => \Config\Services::validation(),
        ];
        return view('anggota/form', $data);
    }

    public function store()
    {
        $rules = $this->anggotaModel->validationRules;

        if (!$this->validate($rules, $this->anggotaModel->validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->anggotaModel->save([
            'nama'      => $this->request->getPost('nama'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'email'     => $this->request->getPost('email'),
        ]);

        session()->setFlashdata('success', 'Data anggota berhasil ditambahkan.');
        return redirect()->to(base_url('anggota'));
    }

    public function edit($id = null)
    {
        $anggota = $this->anggotaModel->find($id);

        if (!$anggota) {
            throw new PageNotFoundException('Anggota tidak ditemukan: ' . $id);
        }

        $data = [
            'title'      => 'Edit Anggota',
            'page_title' => 'Edit Anggota',
            'breadcrumb' => 'Data Master / Anggota / Edit Anggota',
            'anggota'    => $anggota,
            'validation' => \Config\Services::validation(),
        ];
        return view('anggota/form', $data);
    }

    public function update($id = null)
    {
        log_message('debug', 'AnggotaController update method called for ID: ' . $id);
        log_message('debug', 'POST Data: ' . json_encode($this->request->getPost()));

        // Mengatur aturan validasi secara eksplisit untuk update
        $rules = [
            'nama'      => 'required|min_length[3]|max_length[100]',
            'jurusan'   => 'required|max_length[100]',
            'no_telp'   => 'required|max_length[20]|is_unique[anggota.no_telp,id,' . $id . ']',
            // PERUBAHAN DI SINI: Menggunakan 'permit_empty' untuk email
            'email'     => 'permit_empty|valid_email|is_unique[anggota.email,id,' . $id . ']',
        ];

        log_message('debug', 'Validation rules for update: ' . json_encode($rules));

        if (!$this->validate($rules, $this->anggotaModel->validationMessages)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataToUpdate = [
            'nama'      => $this->request->getPost('nama'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'email'     => $this->request->getPost('email'),
        ];
        log_message('debug', 'Data to update: ' . json_encode($dataToUpdate));

        try {
            $updated = $this->anggotaModel->update($id, $dataToUpdate);

            if ($updated) {
                if ($this->anggotaModel->db->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Data anggota berhasil diperbarui.');
                    log_message('debug', 'Anggota data updated successfully. Affected rows: ' . $this->anggotaModel->db->affectedRows());
                } else {
                    session()->setFlashdata('info', 'Tidak ada perubahan pada data anggota.');
                    log_message('debug', 'No changes detected for Anggota ID: ' . $id);
                }
            } else {
                $errors = $this->anggotaModel->errors();
                if (!empty($errors)) {
                    $errorMessages = implode('<br>', $errors);
                    session()->setFlashdata('error', 'Gagal memperbarui data anggota: ' . $errorMessages);
                    log_message('error', 'Failed to update Anggota ID: ' . $id . ' with model errors: ' . json_encode($errors));
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui data anggota. Mungkin ada masalah database yang tidak terdeteksi atau data tidak berubah.');
                    log_message('error', 'Failed to update Anggota ID: ' . $id . ' without specific model errors.');
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat memperbarui data anggota: ' . $e->getMessage());
            log_message('error', 'Exception caught during Anggota update for ID ' . $id . ': ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->to(base_url('anggota'));
    }

    public function delete($id = null)
    {
        if ($this->anggotaModel->delete($id)) {
            session()->setFlashdata('success', 'Data anggota berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data anggota.');
        }
        return redirect()->to(base_url('anggota'));
    }
}

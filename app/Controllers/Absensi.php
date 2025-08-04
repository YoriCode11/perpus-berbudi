<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Absensi Pengunjung',
            'page_title' => 'Absensi Pengunjung',
            'breadcrumb' => 'Transaksi / Absensi',
            'absensi'    => $this->absensiModel->getAbsensiDetails(),
            'validation' => \Config\Services::validation(),
        ];
        // Cukup panggil view anak, dia akan extend layout-nya sendiri
        return view('absensi/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Catat Absensi Baru',
            'page_title' => 'Catat Absensi Baru',
            'breadcrumb' => 'Transaksi / Absensi / Baru',
            'anggota'    => $this->anggotaModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        // Cukup panggil view anak, dia akan extend layout-nya sendiri
        return view('absensi/create', $data);
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'id_anggota' => [
                'rules' => 'required|numeric|is_not_unique[anggota.id]',
                'errors' => [
                    'required'      => 'Anggota harus dipilih.',
                    'numeric'       => 'Anggota yang dipilih tidak valid.',
                    'is_not_unique' => 'Anggota tidak terdaftar.',
                ]
            ],
        ])) {
            return redirect()->to(base_url('absensi/create'))->withInput();
        }

        $id_anggota = $this->request->getPost('id_anggota');

        // Cek apakah anggota ini sudah check-in dan belum check-out
        $anggotaSedangMembaca = $this->absensiModel->getAnggotaSedangMembaca($id_anggota);

        if ($anggotaSedangMembaca) {
            session()->setFlashdata('error', 'Anggota ini sudah tercatat masuk dan belum keluar.');
            return redirect()->to(base_url('absensi/create'))->withInput();
        }

        // Simpan data absensi masuk
        $this->absensiModel->save([
            'id_anggota'    => $id_anggota,
            'tanggal_masuk' => date('Y-m-d H:i:s'),
            'status'        => 'masuk',
        ]);

        session()->setFlashdata('success', 'Absensi masuk anggota berhasil dicatat.');
        return redirect()->to(base_url('absensi'));
    }

    public function checkout($id_absensi = null)
    {
        if ($id_absensi === null) {
            session()->setFlashdata('error', 'ID Absensi tidak valid.');
            return redirect()->to(base_url('absensi'));
        }

        $absensi = $this->absensiModel->find($id_absensi);

        if (!$absensi || $absensi['status'] === 'keluar') {
            session()->setFlashdata('error', 'Absensi tidak ditemukan atau sudah tercatat keluar.');
            return redirect()->to(base_url('absensi'));
        }

        // Update status absensi menjadi 'keluar' dan set tanggal_keluar
        $this->absensiModel->update($id_absensi, [
            'tanggal_keluar' => date('Y-m-d H:i:s'),
            'status'         => 'keluar',
        ]);

        session()->setFlashdata('success', 'Absensi keluar anggota berhasil dicatat.');
        return redirect()->to(base_url('absensi'));
    }

    public function delete($id = null)
    {
        if ($this->absensiModel->delete($id)) {
            session()->setFlashdata('success', 'Catatan absensi berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus catatan absensi.');
        }
        return redirect()->to(base_url('absensi'));
    }
}
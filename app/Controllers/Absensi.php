<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use CodeIgniter\Controller;

class Absensi extends Controller
{
    protected $attendanceModel;
    protected $memberModel;

    public function __construct()
    {
        $this->attendanceModel = new AbsensiModel();
        $this->memberModel     = new AnggotaModel();
    }

    // List absensi dengan nama member
    public function index()
    {
        $attendances = $this->attendanceModel
            ->select('attendance.*, members.name as member_name, members.nis as member_nis')
            ->join('members', 'members.id = attendance.member_id')
            ->orderBy('attendance.date', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Data Absensi',
            'page_title'  => 'Daftar Absensi',
            'breadcrumb'  => 'Transaksi / Absensi',
            'attendances' => $attendances
        ];

        return view('absensi/index', $data);
    }

    // Form input absensi
    public function new()
    {
        $members = $this->memberModel->findAll();

        $data = [
            'title'      => 'Tambah Absensi',
            'page_title' => 'Form Absensi',
            'breadcrumb' => 'Transaksi / Absensi / Tambah',
            'members'    => $members
        ];

        return view('absensi/form', $data);
    }

    // Simpan absensi baru
    public function store()
    {
        $data = $this->request->getPost();

        if (!$this->attendanceModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->attendanceModel->errors());
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil ditambahkan.');
    }

    // Edit absensi
    public function edit($id)
    {
        $attendance = $this->attendanceModel->find($id);
        $members    = $this->memberModel->findAll();

        if (!$attendance) {
            return redirect()->to('/absensi')->with('error', 'Data absensi tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Absensi',
            'page_title' => 'Edit Absensi',
            'breadcrumb' => 'Transaksi / Absensi / Edit',
            'attendance' => $attendance,
            'members'    => $members
        ];

        return view('absensi/form_edit', $data);
    }

    // Update absensi
    public function update($id)
    {
        $data = $this->request->getPost();

        if (!$this->attendanceModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->attendanceModel->errors());
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil diperbarui.');
    }

    // Hapus absensi
    public function delete($id)
    {
        $this->attendanceModel->delete($id);
        return redirect()->to('/absensi')->with('success', 'Absensi berhasil dihapus.');
    }
}

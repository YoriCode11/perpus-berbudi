<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->anggotaModel = new AnggotaModel();
        helper(['form', 'url']);
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
        return view('absensi/index', $data);
    }

    public function new()
    {
        $data = [
            'title'      => 'Catat Absensi Baru',
            'page_title' => 'Catat Absensi Baru',
            'breadcrumb' => 'Transaksi / Absensi / Baru',
            // Pastikan kita mengambil SEMUA anggota (termasuk soft-deleted jika diperlukan, atau hanya yang aktif)
            // Untuk dropdown absensi, biasanya hanya anggota aktif yang bisa check-in
            'anggota'    => $this->anggotaModel->findAll(), // findAll() secara default mengabaikan soft-deleted
            'validation' => \Config\Services::validation(),
        ];
        // Log data anggota yang dikirim ke view
        log_message('debug', 'Anggota data for absensi form: ' . json_encode($data['anggota']));
        return view('absensi/form', $data);
    }

    public function create()
    {
        // Ambil data tanggal dan jam dari form
        $tanggal_masuk_date = $this->request->getPost('tanggal_masuk_date');
        $tanggal_masuk_time = $this->request->getPost('tanggal_masuk_time');

        // Gabungkan tanggal dan jam menjadi format datetime yang diharapkan database
        $tanggal_masuk_datetime = $tanggal_masuk_date . ' ' . $tanggal_masuk_time . ':00';

        // Validasi input
        // Aturan validasi harus mencerminkan field yang ada di form
        $rules = [
            'id_anggota'         => 'required|numeric|is_not_unique[anggota.id,deleted_at,NULL]',
            'tanggal_masuk_date' => 'required|valid_date[Y-m-d]',
            'tanggal_masuk_time' => 'required|valid_date[H:i]', // Menambahkan validasi format jam
        ];

        $messages = [
            'id_anggota' => [
                'required'      => 'Anggota harus dipilih.',
                'numeric'       => 'Anggota yang dipilih tidak valid.',
                'is_not_unique' => 'Anggota tidak terdaftar atau sudah tidak aktif.',
            ],
            'tanggal_masuk_date' => [
                'required'   => 'Tanggal masuk harus diisi.',
                'valid_date' => 'Format tanggal masuk tidak valid.',
            ],
            'tanggal_masuk_time' => [
                'required'   => 'Jam masuk harus diisi.',
                'valid_date' => 'Format jam masuk tidak valid (HH:MM).',
            ],
        ];

        // Log data POST dan aturan validasi sebelum validasi
        log_message('debug', 'Absensi create POST Data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'Absensi create Validation Rules: ' . json_encode($rules));

        if (!$this->validate($rules, $messages)) {
            log_message('error', 'Validation failed for adding new absensi. Errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $id_anggota = $this->request->getPost('id_anggota');

        // Cek apakah anggota ini sudah check-in dan belum check-out (status 'masuk')
        $anggotaSedangMembaca = $this->absensiModel->getAnggotaSedangMembaca($id_anggota);

        if ($anggotaSedangMembaca) {
            session()->setFlashdata('error', 'Anggota ini sudah tercatat masuk dan belum keluar.');
            return redirect()->to(base_url('absensi/new'))->withInput();
        }

        // Simpan data absensi masuk
        try {
            $saved = $this->absensiModel->save([
                'id_anggota'    => $id_anggota,
                'tanggal_masuk' => $tanggal_masuk_datetime,
                'status'        => 'masuk', // Status diisi di controller, bukan dari form
            ]);

            if ($saved) {
                session()->setFlashdata('success', 'Absensi masuk anggota berhasil dicatat.');
            } else {
                session()->setFlashdata('error', 'Gagal mencatat absensi. Mungkin ada masalah database.');
                log_message('error', 'Failed to save absensi. Model errors: ' . json_encode($this->absensiModel->errors()));
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat mencatat absensi: ' . $e->getMessage());
            log_message('error', 'Exception caught during absensi creation: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->to(base_url('absensi'));
    }

    public function edit($id = null)
    {
        $absensi = $this->absensiModel->withDeleted()->find($id);

        if (!$absensi) {
            throw new PageNotFoundException('Catatan absensi tidak ditemukan: ' . $id);
        }

        $data = [
            'title'      => 'Edit Absensi',
            'page_title' => 'Edit Absensi',
            'breadcrumb' => 'Transaksi / Absensi / Edit',
            'absensi'    => $absensi,
            'anggota'    => $this->anggotaModel->findAll(), // Hanya anggota aktif untuk edit
            'validation' => \Config\Services::validation(),
        ];
        return view('absensi/form', $data);
    }

    public function update($id = null)
    {
        // Ambil data tanggal dan jam dari form (jika ada form edit untuk tanggal/jam)
        $tanggal_masuk_date = $this->request->getPost('tanggal_masuk_date');
        $tanggal_masuk_time = $this->request->getPost('tanggal_masuk_time');
        $tanggal_masuk_datetime = $tanggal_masuk_date . ' ' . $tanggal_masuk_time . ':00';

        // Aturan validasi untuk update
        $rules = [
            'id_anggota'         => 'required|numeric|is_not_unique[anggota.id,deleted_at,NULL]',
            'tanggal_masuk_date' => 'required|valid_date[Y-m-d]',
            'tanggal_masuk_time' => 'required|valid_date[H:i]',
        ];
        $messages = [
            'id_anggota' => [
                'required'      => 'Anggota harus dipilih.',
                'numeric'       => 'Anggota yang dipilih tidak valid.',
                'is_not_unique' => 'Anggota tidak terdaftar atau sudah tidak aktif.',
            ],
            'tanggal_masuk_date' => [
                'required'   => 'Tanggal masuk harus diisi.',
                'valid_date' => 'Format tanggal masuk tidak valid.',
            ],
            'tanggal_masuk_time' => [
                'required'   => 'Jam masuk harus diisi.',
                'valid_date' => 'Format jam masuk tidak valid (HH:MM).',
            ],
        ];


        if (!$this->validate($rules, $messages)) {
            log_message('error', 'Validation failed for updating absensi. Errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataToUpdate = [
            'id_anggota'    => $this->request->getPost('id_anggota'),
            'tanggal_masuk' => $tanggal_masuk_datetime,
            // Status tidak diupdate di sini, karena ini untuk check-in/out
        ];

        try {
            $updated = $this->absensiModel->update($id, $dataToUpdate);

            if ($updated) {
                if ($this->absensiModel->db->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Data absensi berhasil diperbarui.');
                } else {
                    session()->setFlashdata('info', 'Tidak ada perubahan pada data absensi.');
                }
            } else {
                $errors = $this->absensiModel->errors();
                if (!empty($errors)) {
                    $errorMessages = implode('<br>', $errors);
                    session()->setFlashdata('error', 'Gagal memperbarui data absensi: ' . $errorMessages);
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui data absensi. Mungkin ada masalah database atau data tidak berubah.');
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat memperbarui data absensi: ' . $e->getMessage());
            log_message('error', 'Exception caught during Absensi update for ID ' . $id . ': ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->to(base_url('absensi'));
    }

    public function checkout($id_absensi = null)
    {
        if ($id_absensi === null) {
            session()->setFlashdata('error', 'ID Absensi tidak valid.');
            return redirect()->to(base_url('absensi'));
        }

        $absensi = $this->absensiModel->withDeleted()->find($id_absensi);

        if (!$absensi || $absensi['status'] === 'keluar') {
            session()->setFlashdata('error', 'Absensi tidak ditemukan atau sudah tercatat keluar.');
            return redirect()->to(base_url('absensi'));
        }

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

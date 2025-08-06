<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $anggotaModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->anggotaModel    = new AnggotaModel();
        $this->bukuModel       = new BukuModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Peminjaman',
            'page_title' => 'Data Peminjaman',
            'breadcrumb' => 'Transaksi / Peminjaman',
            'peminjaman' => $this->peminjamanModel->getPeminjamanDetails(),
            'validation' => \Config\Services::validation(),
        ];
        return view('peminjaman/index', $data);
    }

    // Mengubah nama metode dari 'create' menjadi 'new' sesuai konvensi resource
    public function new()
    {
        $data = [
            'title'      => 'Tambah Peminjaman',
            'page_title' => 'Tambah Peminjaman',
            'breadcrumb' => 'Transaksi / Peminjaman / Tambah',
            'validation' => \Config\Services::validation(),
            // Hanya ambil anggota yang aktif (tidak soft-deleted)
            'anggota'    => $this->anggotaModel->findAll(),
            // Hanya ambil buku yang stoknya > 0 dan belum di-soft-delete
            'buku'       => $this->bukuModel->where('stok >', 0)->where('deleted_at', null)->findAll(),
        ];
        log_message('debug', 'Anggota data for peminjaman form: ' . json_encode($data['anggota']));
        log_message('debug', 'Buku data for peminjaman form: ' . json_encode($data['buku']));
        return view('peminjaman/form', $data); // Mengarahkan ke form.php
    }

    // Mengubah nama metode dari 'store' menjadi 'create' sesuai konvensi resource
    public function create()
    {
        // Aturan validasi dari model
        $rules = $this->peminjamanModel->validationRules;

        // Tambahkan aturan kustom untuk stok buku
        $rules['id_buku'] .= '|check_stok_buku';

        // Pesan validasi kustom
        $messages = $this->peminjamanModel->validationMessages;
        $messages['id_buku']['check_stok_buku'] = 'Stok buku yang dipilih tidak tersedia atau habis.';

        // Daftarkan aturan kustom ke validator
        $this->validator->setRule('check_stok_buku', 'Stok Buku', function($value, $data, $field, $rules, $errors) {
            $buku = $this->bukuModel->find($value);
            // Pastikan buku ditemukan dan stoknya > 0
            if ($buku && $buku['stok'] > 0) {
                return true;
            }
            return false;
        }, ['check_stok_buku' => 'Stok buku tidak cukup.']);

        log_message('debug', 'Peminjaman create POST Data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'Peminjaman create Validation Rules (Controller): ' . json_encode($rules));

        if (!$this->validate($rules, $messages)) {
            log_message('error', 'Validation failed for adding new peminjaman. Errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $id_buku = $this->request->getPost('id_buku');
        $tanggal_pinjam = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini

        // Simpan data peminjaman
        $dataPeminjaman = [
            'id_anggota'     => $this->request->getPost('id_anggota'),
            'id_buku'        => $id_buku,
            'tanggal_pinjam' => $tanggal_pinjam,
            'status'         => 'dipinjam', // Default status
        ];

        try {
            if ($this->peminjamanModel->save($dataPeminjaman)) {
                // Kurangi stok buku
                $buku = $this->bukuModel->find($id_buku);
                if ($buku) {
                    $this->bukuModel->update($id_buku, ['stok' => $buku['stok'] - 1]);
                }

                session()->setFlashdata('success', 'Peminjaman buku berhasil dicatat.');
                return redirect()->to(base_url('peminjaman'));
            } else {
                session()->setFlashdata('error', 'Gagal mencatat peminjaman buku. Mungkin ada masalah database.');
                log_message('error', 'Failed to save peminjaman. Model errors: ' . json_encode($this->peminjamanModel->errors()));
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat mencatat peminjaman: ' . $e->getMessage());
            log_message('error', 'Exception caught during peminjaman creation: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
            return redirect()->back()->withInput();
        }
    }

    // Metode edit, update, delete, dan kembalikan tetap seperti sebelumnya,
    // namun pastikan mereka menggunakan withDeleted() jika perlu mengambil data soft-deleted.
    // Contoh untuk edit:
    public function edit($id = null)
    {
        $peminjaman = $this->peminjamanModel->withDeleted()->find($id); // Ambil peminjaman yang mungkin soft-deleted

        if (!$peminjaman) {
            throw new PageNotFoundException('Peminjaman tidak ditemukan: ' . $id);
        }

        $data = [
            'title'      => 'Edit Peminjaman',
            'page_title' => 'Edit Peminjaman',
            'breadcrumb' => 'Transaksi / Peminjaman / Edit',
            'peminjaman' => $peminjaman,
            'validation' => \Config\Services::validation(),
            'anggota'    => $this->anggotaModel->findAll(), // Hanya anggota aktif
            'buku'       => $this->bukuModel->where('stok >', 0)->where('deleted_at', null)->findAll(), // Hanya buku aktif dengan stok > 0
        ];
        return view('peminjaman/form', $data);
    }

    public function update($id = null)
    {
        // Aturan validasi dari model
        $rules = $this->peminjamanModel->validationRules;
        // Tambahkan aturan kustom untuk stok buku (jika diizinkan update buku di form edit)
        $rules['id_buku'] .= '|check_stok_buku'; // Tambahkan aturan kustom

        // Pesan validasi kustom
        $messages = $this->peminjamanModel->validationMessages;
        $messages['id_buku']['check_stok_buku'] = 'Stok buku yang dipilih tidak tersedia atau habis.';

        // Daftarkan aturan kustom ke validator
        $this->validator->setRule('check_stok_buku', 'Stok Buku', function($value, $data, $field, $rules, $errors) {
            $buku = $this->bukuModel->find($value);
            // Pastikan buku ditemukan dan stoknya > 0
            if ($buku && $buku['stok'] > 0) {
                return true;
            }
            return false;
        }, ['check_stok_buku' => 'Stok buku tidak cukup.']);

        if (!$this->validate($rules, $messages)) {
            log_message('error', 'Validation failed for updating peminjaman. Errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Ambil data dari form
        $dataPeminjaman = [
            'id_anggota'     => $this->request->getPost('id_anggota'),
            'id_buku'        => $this->request->getPost('id_buku'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'), // Jika tanggal pinjam bisa diubah
            // 'status' tidak diubah di sini, karena ada metode kembalikan()
        ];

        try {
            $updated = $this->peminjamanModel->update($id, $dataPeminjaman);

            if ($updated) {
                if ($this->peminjamanModel->db->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Data peminjaman berhasil diperbarui.');
                } else {
                    session()->setFlashdata('info', 'Tidak ada perubahan pada data peminjaman.');
                }
            } else {
                $errors = $this->peminjamanModel->errors();
                if (!empty($errors)) {
                    $errorMessages = implode('<br>', $errors);
                    session()->setFlashdata('error', 'Gagal memperbarui data peminjaman: ' . $errorMessages);
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui data peminjaman. Mungkin ada masalah database atau data tidak berubah.');
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat memperbarui data peminjaman: ' . $e->getMessage());
            log_message('error', 'Exception caught during Peminjaman update for ID ' . $id . ': ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->to(base_url('peminjaman'));
    }

    public function kembalikan($id_peminjaman = null)
    {
        if ($id_peminjaman === null) {
            session()->setFlashdata('error', 'ID Peminjaman tidak valid.');
            return redirect()->to(base_url('peminjaman'));
        }

        // Cari data peminjaman (sertakan yang soft-deleted jika perlu untuk kasus edge)
        $peminjaman = $this->peminjamanModel->withDeleted()->find($id_peminjaman);

        if (!$peminjaman || $peminjaman['status'] === 'kembali') {
            session()->setFlashdata('error', 'Peminjaman tidak ditemukan atau sudah dikembalikan.');
            return redirect()->to(base_url('peminjaman'));
        }

        $this->db->transStart();

        try {
            $this->peminjamanModel->update($id_peminjaman, [
                'tanggal_kembali' => date('Y-m-d H:i:s'),
                'status'          => 'kembali',
            ]);

            $buku = $this->bukuModel->find($peminjaman['id_buku']);
            if ($buku) {
                $this->bukuModel->update($peminjaman['id_buku'], ['stok' => $buku['stok'] + 1]);
            } else {
                log_message('error', 'Buku dengan ID ' . $peminjaman['id_buku'] . ' tidak ditemukan saat pengembalian.');
                throw new \Exception('Buku terkait tidak ditemukan.');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal melakukan transaksi pengembalian.');
            }

            session()->setFlashdata('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal mencatat pengembalian buku: ' . $e->getMessage());
            log_message('error', 'Exception caught during peminjaman kembalikan: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->to(base_url('peminjaman'));
    }

    public function delete($id = null)
    {
        if ($this->peminjamanModel->delete($id)) {
            session()->setFlashdata('success', 'Catatan peminjaman berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus catatan peminjaman.');
        }
        return redirect()->to(base_url('peminjaman'));
    }
}

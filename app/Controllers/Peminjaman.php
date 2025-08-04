<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel; // Untuk ambil data anggota
use App\Models\BukuModel;    // Untuk ambil data buku dan update stok
use CodeIgniter\Controller;

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
            'peminjaman' => $this->peminjamanModel->getPeminjamanDetails(), // Ambil detail peminjaman
            'validation' => \Config\Services::validation(),
        ];
        return view('peminjaman/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Peminjaman',
            'page_title' => 'Tambah Peminjaman',
            'breadcrumb' => 'Transaksi / Peminjaman / Tambah',
            'validation' => \Config\Services::validation(),
            'anggota'    => $this->anggotaModel->findAll(), // Ambil semua anggota
            'buku'       => $this->bukuModel->where('stok >', 0)->findAll(), // Ambil buku yang stoknya tersedia
        ];
        return view('peminjaman/create', $data);
    }

    public function store()
    {
        // Aturan validasi tambahan untuk stok buku
        $rules = $this->peminjamanModel->validationRules;
        $rules['id_buku'] .= '|check_stok_buku'; // Tambahkan aturan kustom

        // Pesan validasi kustom
        $messages = $this->peminjamanModel->validationMessages;
        $messages['id_buku']['check_stok_buku'] = 'Stok buku yang dipilih tidak tersedia atau habis.';

        // Daftarkan aturan kustom ke validator
        $this->validator->setRule('check_stok_buku', 'Stok Buku', function($value, $data, $field, $rules, $errors) {
            $buku = $this->bukuModel->find($value);
            if ($buku && $buku['stok'] > 0) {
                return true;
            }
            return false;
        }, ['check_stok_buku' => 'Stok buku tidak cukup.']);


        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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

        if ($this->peminjamanModel->save($dataPeminjaman)) {
            // Kurangi stok buku
            $buku = $this->bukuModel->find($id_buku);
            if ($buku) {
                $this->bukuModel->update($id_buku, ['stok' => $buku['stok'] - 1]);
            }

            session()->setFlashdata('success', 'Peminjaman buku berhasil dicatat.');
            return redirect()->to(base_url('peminjaman'));
        } else {
            session()->setFlashdata('error', 'Gagal mencatat peminjaman buku.');
            return redirect()->back()->withInput();
        }
    }

    public function kembalikan($id_peminjaman = null)
    {
        // Pastikan ID peminjaman ada
        if ($id_peminjaman === null) {
            session()->setFlashdata('error', 'ID Peminjaman tidak valid.');
            return redirect()->to(base_url('peminjaman'));
        }

        // Cari data peminjaman
        $peminjaman = $this->peminjamanModel->find($id_peminjaman);

        // Jika peminjaman tidak ditemukan atau statusnya sudah kembali
        if (!$peminjaman || $peminjaman['status'] === 'kembali') {
            session()->setFlashdata('error', 'Peminjaman tidak ditemukan atau sudah dikembalikan.');
            return redirect()->to(base_url('peminjaman'));
        }

        // Mulai transaksi database (opsional tapi disarankan untuk operasi yang saling terkait)
        $this->db->transStart();

        try {
            // Update status peminjaman menjadi 'kembali' dan set tanggal_kembali
            $this->peminjamanModel->update($id_peminjaman, [
                'tanggal_kembali' => date('Y-m-d H:i:s'), // Tanggal dan waktu sekarang
                'status'          => 'kembali',
            ]);

            // Tambahkan stok buku
            $buku = $this->bukuModel->find($peminjaman['id_buku']);
            if ($buku) {
                $this->bukuModel->update($peminjaman['id_buku'], ['stok' => $buku['stok'] + 1]);
            } else {
                // Log jika buku tidak ditemukan (kasus jarang terjadi jika FK benar)
                log_message('error', 'Buku dengan ID ' . $peminjaman['id_buku'] . ' tidak ditemukan saat pengembalian.');
                throw new \Exception('Buku terkait tidak ditemukan.');
            }

            // Commit transaksi jika semua berhasil
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal melakukan transaksi pengembalian.');
            }

            session()->setFlashdata('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal mencatat pengembalian buku: ' . $e->getMessage());
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
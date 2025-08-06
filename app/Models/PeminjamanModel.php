<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = ['id_anggota', 'id_buku', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        // PERBAIKAN: Tambahkan 'deleted_at,NULL' untuk is_not_unique pada anggota.id dan buku.id
        'id_anggota'     => 'required|numeric|is_not_unique[anggota.id,deleted_at,NULL]',
        'id_buku'        => 'required|numeric|is_not_unique[buku.id,deleted_at,NULL]',
        'tanggal_pinjam' => 'required|valid_date[Y-m-d H:i:s]',
        'status'         => 'in_list[dipinjam,kembali]',
    ];
    protected $validationMessages = [
        'id_anggota' => [
            'required'      => 'Anggota harus dipilih.',
            'numeric'       => 'Anggota yang dipilih tidak valid.',
            'is_not_unique' => 'Anggota tidak terdaftar atau sudah tidak aktif.',
        ],
        'id_buku' => [
            'required'      => 'Buku harus dipilih.',
            'numeric'       => 'Buku yang dipilih tidak valid.',
            'is_not_unique' => 'Buku tidak terdaftar atau sudah tidak aktif.',
        ],
        'tanggal_pinjam' => [
            'required'   => 'Tanggal pinjam harus diisi.',
            'valid_date' => 'Format tanggal pinjam tidak valid.',
        ],
        'status' => [
            'in_list' => 'Status tidak valid.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Fungsi untuk mengambil data peminjaman beserta nama anggota, judul buku, dan kategori buku
    public function getPeminjamanDetails($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('peminjaman.*, anggota.nama as nama_anggota, buku.judul as judul_buku, kategori.nama_kategori');
        $builder->join('anggota', 'anggota.id = peminjaman.id_anggota');
        $builder->join('buku', 'buku.id = peminjaman.id_buku');
        $builder->join('kategori', 'kategori.id = buku.id_kategori');

        // Hanya tampilkan peminjaman yang belum di-soft-delete
        $builder->where('peminjaman.deleted_at IS NULL');
        // Hanya tampilkan peminjaman dari anggota dan buku yang aktif
        $builder->where('anggota.deleted_at IS NULL');
        $builder->where('buku.deleted_at IS NULL');

        if ($id) {
            return $builder->where('peminjaman.id', $id)->get()->getRowArray();
        } else {
            return $builder->orderBy('peminjaman.created_at', 'DESC')->get()->getResultArray();
        }
    }
}

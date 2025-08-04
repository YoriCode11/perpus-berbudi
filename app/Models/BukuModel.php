<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'id_kategori', 'stok'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'judul'        => 'required|min_length[3]|max_length[255]',
        'penulis'      => 'required|min_length[3]|max_length[100]',
        'penerbit'     => 'required|min_length[3]|max_length[100]',
        'tahun_terbit' => 'required|exact_length[4]|numeric|less_than_equal_to[2025]',
        // PERBAIKAN: Gunakan parameter tambahan 'deleted_at,NULL' untuk mengabaikan data yang soft-deleted
        'id_kategori'  => 'required|numeric|is_not_unique[kategori.id,deleted_at,NULL]',
        'stok'         => 'required|numeric|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'judul' => [
            'required'   => 'Judul buku harus diisi.',
            'min_length' => 'Judul buku minimal 3 karakter.',
            'max_length' => 'Judul buku maksimal 255 karakter.',
        ],
        'penulis' => [
            'required'   => 'Nama penulis harus diisi.',
            'min_length' => 'Nama penulis minimal 3 karakter.',
            'max_length' => 'Nama penulis maksimal 100 karakter.',
        ],
        'penerbit' => [
            'required'   => 'Nama penerbit harus diisi.',
            'min_length' => 'Nama penerbit minimal 3 karakter.',
            'max_length' => 'Nama penerbit maksimal 100 karakter.',
        ],
        'tahun_terbit' => [
            'required'           => 'Tahun terbit harus diisi.',
            'exact_length'       => 'Tahun terbit harus 4 digit angka.',
            'numeric'            => 'Tahun terbit harus berupa angka.',
            'less_than_equal_to' => 'Tahun terbit tidak boleh lebih dari tahun sekarang (2025).',
        ],
        'id_kategori' => [
            'required'      => 'Kategori buku harus dipilih.',
            'numeric'       => 'Kategori yang dipilih tidak valid.',
            'is_not_unique' => 'Kategori yang dipilih tidak terdaftar.',
        ],
        'stok' => [
            'required'              => 'Stok buku harus diisi.',
            'numeric'               => 'Stok harus berupa angka.',
            'greater_than_equal_to' => 'Stok buku tidak boleh kurang dari 0.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Fungsi untuk mengambil data buku beserta nama kategori
    public function getBukuWithKategori($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('buku.*, kategori.nama_kategori'); // Pilih semua kolom buku dan nama_kategori
        $builder->join('kategori', 'kategori.id = buku.id_kategori'); // Join dengan tabel kategori
        $builder->where('buku.deleted_at IS NULL'); // HANYA tampilkan buku yang belum dihapus

        if ($id) {
            return $builder->where('buku.id', $id)->get()->getRowArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }
}

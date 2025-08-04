<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Atau 'object' jika lebih suka
    protected $useSoftDeletes   = true; // Menggunakan soft delete

    protected $allowedFields    = ['nama_kategori'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        // PERUBAHAN PENTING DI SINI: Menambahkan kondisi untuk mengabaikan soft-deleted records
        'nama_kategori' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id,{id},deleted_at IS NULL]',
    ];
    protected $validationMessages = [
        'nama_kategori' => [
            'required'   => 'Nama kategori harus diisi.',
            'min_length' => 'Nama kategori minimal 3 karakter.',
            'max_length' => 'Nama kategori maksimal 100 karakter.',
            'is_unique'  => 'Nama kategori ini sudah ada.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}

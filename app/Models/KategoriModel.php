<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'description'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Default validation rules untuk CREATE
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name]',
        'description' => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama kategori harus diisi.',
            'min_length' => 'Nama kategori minimal 3 karakter.',
            'max_length' => 'Nama kategori maksimal 100 karakter.',
            'is_unique' => 'Nama kategori ini sudah ada.',
        ],
        'description' => [
            'required' => 'Deskripsi kategori harus diisi.',
            'min_length' => 'Deskripsi kategori minimal 3 karakter.',
        ],
    ];

    protected $skipValidation = false;
}

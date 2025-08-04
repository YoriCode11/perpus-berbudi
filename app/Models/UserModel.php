<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Atau 'object' jika lebih suka
    protected $useSoftDeletes   = true; // Menggunakan soft delete

    protected $allowedFields    = ['username', 'email', 'password', 'role'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi.',
            'alpha_numeric_space' => 'Username hanya boleh berisi huruf, angka, dan spasi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 100 karakter.',
            'is_unique'  => 'Username ini sudah terdaftar.',
        ],
        'email'    => [
            'required'    => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique'   => 'Email ini sudah terdaftar.',
        ],
        'password' => [
            'required'   => 'Password harus diisi.',
            'min_length' => 'Password minimal 8 karakter.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    // Pastikan 'jurusan' ada di allowedFields
    protected $allowedFields    = ['nama', 'jurusan', 'no_telp', 'email'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks untuk memproses data sebelum insert/update
    protected $beforeInsert = ['processEmailField'];
    protected $beforeUpdate = ['processEmailField'];

    // Validation Rules
    protected $validationRules = [
        'nama'      => 'required|min_length[3]|max_length[100]',
        'jurusan'   => 'required|max_length[100]',
        'no_telp'   => 'required|max_length[20]|is_unique[anggota.no_telp,id,{id}]',
        // Mengubah 'permit_empty' menjadi 'if_exist' untuk email.
        // Rule 'is_unique' akan tetap dieksekusi jika email ada dan tidak kosong.
        'email'     => 'if_exist|valid_email|is_unique[anggota.email,id,{id}]',
    ];

    // Validation Messages
    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama anggota harus diisi.',
            'min_length' => 'Nama anggota minimal 3 karakter.',
            'max_length' => 'Nama anggota maksimal 100 karakter.',
        ],
        'jurusan' => [
            'required'   => 'Jurusan anggota harus dipilih.',
            'max_length' => 'Jurusan anggota maksimal 100 karakter.',
        ],
        'no_telp' => [
            'required'   => 'Nomor telepon harus diisi.',
            'max_length' => 'Nomor telepon maksimal 20 karakter.',
            'is_unique'  => 'Nomor telepon ini sudah terdaftar.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
            'is_unique'   => 'Email ini sudah terdaftar.',
        ],
    ];

    /**
     * Callback untuk memproses field email: mengubah string kosong menjadi NULL.
     * @param array $data
     * @return array
     */
    protected function processEmailField(array $data)
    {
        // Pastikan 'data' dan 'email' ada sebelum mencoba mengaksesnya
        if (isset($data['data']['email']) && $data['data']['email'] === '') {
            $data['data']['email'] = null; // Ubah string kosong menjadi NULL
        }
        return $data;
    }
}

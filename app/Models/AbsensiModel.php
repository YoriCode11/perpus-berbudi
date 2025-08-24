<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = ['member_id', 'date', 'status', 'time_in', 'time_out'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Rules untuk validasi
    protected $validationRules = [
        'member_id' => 'required|integer',
        'date'      => 'required|valid_date',
        'status'    => 'required|in_list[Hadir,Tidak Hadir]',
        'time_in'   => 'permit_empty',
        'time_out'  => 'permit_empty'
    ];

    protected $validationMessages = [
        'member_id' => [
            'required' => 'Anggota wajib dipilih.',
            'integer'  => 'ID anggota tidak valid.'
        ],
        'date' => [
            'required'   => 'Tanggal absen wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid.'
        ],
        'status' => [
            'required' => 'Status absen wajib diisi.',
            'in_list'  => 'Status hanya boleh Hadir atau Tidak Hadir.'
        ],
        'time_in' => [
            'valid_time' => 'Format jam masuk tidak valid (HH:MM:SS).'
        ],
        'time_out' => [
            'valid_time' => 'Format jam keluar tidak valid (HH:MM:SS).'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nis',
        'name',
        'class',
        'major',
        'phone',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $validationRules = [
        'nis'     => 'required|numeric|is_unique[members.nis,id,{id}]',
        'name'    => 'required|min_length[3]',
        'class'   => 'required',
        'major' => 'required',
        'phone'   => 'permit_empty|numeric|min_length[11]',
        'status'  => 'required|in_list[aktif,nonaktif]'
    ];

    protected $validationMessages = [
        'nis' => [
            'required'  => 'NIS wajib diisi',
            'numeric'   => 'NIS harus berupa angka',
            'is_unique' => 'NIS sudah terdaftar'
        ],
        'name' => [
            'required'   => 'Nama wajib diisi',
            'min_length' => 'Nama minimal 3 karakter'
        ],
        'class' => [
            'required' => 'Kelas wajib dipilih'
        ],
        'major' => [
            'required' => 'Jurusan wajib diisi'
        ],
        'phone' => [
            'numeric' => 'Telepon harus berupa angka',
            'min_length' => 'Nomor Telepon  minimal 11 angka'
        ],
        'status' => [
            'required' => 'Status wajib dipilih',
            'in_list'  => 'Status harus Aktif atau Nonaktif'
        ]
    ];
}

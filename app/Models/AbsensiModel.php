<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['member_id', 'tanggal', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'member_id' => 'required|numeric',
        'tanggal'   => 'required|valid_date',
        'status'    => 'required|in_list[hadir,izin,sakit,alpa]'
    ];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = ['id_anggota', 'tanggal_masuk', 'tanggal_keluar', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_anggota'    => 'required|numeric|is_not_unique[anggota.id]',
        'tanggal_masuk' => 'required|valid_date[Y-m-d H:i:s]',
        'status'        => 'in_list[masuk,keluar]',
    ];
    protected $validationMessages = [
        'id_anggota' => [
            'required'      => 'Anggota harus dipilih.',
            'numeric'       => 'Anggota yang dipilih tidak valid.',
            'is_not_unique' => 'Anggota tidak terdaftar.',
        ],
        'tanggal_masuk' => [
            'required'   => 'Tanggal masuk harus diisi.',
            'valid_date' => 'Format tanggal masuk tidak valid.',
        ],
        'status' => [
            'in_list' => 'Status tidak valid.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Fungsi untuk mengambil data absensi beserta nama anggota
    public function getAbsensiDetails($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('absensi.*, anggota.nama as nama_anggota, anggota.no_telp as no_telp_anggota');
        $builder->join('anggota', 'anggota.id = absensi.id_anggota');

        if ($id) {
            return $builder->where('absensi.id', $id)->get()->getRowArray();
        } else {
            return $builder->orderBy('absensi.created_at', 'DESC')->get()->getResultArray(); // Gunakan getResultArray()
        }
    }

    // Fungsi untuk mengecek absensi anggota yang masih "masuk"
    public function getAnggotaSedangMembaca($id_anggota)
    {
        return $this->where('id_anggota', $id_anggota)
                    ->where('status', 'masuk')
                    ->first();
    }
}
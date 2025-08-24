<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PeminjamanModel extends Model
{
    protected $table            = 'borrowings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'member_id', 'book_id', 'borrow_date', 'return_date', 'status', 'qty'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function checkLateStatus()
    {
        $today = Time::today();

        return $this->where('status', 'Dipinjam')
                    ->where('borrow_date <', $today->subDays(7)->toDateString())
                    ->set(['status' => 'Terlambat'])
                    ->update();
    }
}

<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\BukuModel;
use App\Models\PeminjamanModel;

class Dashboard extends BaseController
{
    protected $memberModel;
    protected $bookModel;
    protected $borrowingModel;

    public function __construct()
    {
        $this->memberModel    = new AnggotaModel();
        $this->bookModel      = new BukuModel();
        $this->borrowingModel = new PeminjamanModel();
    }

    public function index()
    {

        $jumlahAnggota = $this->memberModel->countAllResults();
        $jumlahBuku    = $this->bookModel->countAllResults();

        $bukuDipinjam  = $this->borrowingModel
                            ->where('status', 'Dipinjam')
                            ->countAllResults();

        $bukuTerlambat = $this->borrowingModel
                            ->where('status', 'Terlambat')
                            ->countAllResults();

        $data = [
            'title'         => 'Dashboard',
            'page_title'    => 'Dashboard',
            'breadcrumb'    => 'Dashboard',
            'jumlahAnggota' => $jumlahAnggota,
            'jumlahBuku'    => $jumlahBuku,
            'bukuDipinjam'  => $bukuDipinjam,
            'bukuTerlambat' => $bukuTerlambat
        ];

        return view('dashboard/index', $data);
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'breadcrumb' => 'Dashboard',
        ];
        return view('dashboard/index', $data);
    }
}
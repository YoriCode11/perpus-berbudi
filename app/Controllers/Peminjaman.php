<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;

class Peminjaman extends BaseController
{
    protected $borrowingModel;
    protected $memberModel;
    protected $bookModel;

    public function __construct()
    {
        $this->borrowingModel = new PeminjamanModel();
        $this->memberModel = new AnggotaModel();
        $this->bookModel = new BukuModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Peminjaman',
            'page_title' => 'Peminjaman Buku',
            'breadcrumb' => 'Peminjaman',
            'peminjaman' => $this->borrowingModel
                ->select('borrowings.*, members.name as member_name, books.title as book_title, members.nis as member_nis')
                ->join('members', 'members.id = borrowings.member_id')
                ->join('books', 'books.id = borrowings.book_id')
                ->findAll()
        ];
        return view('peminjaman/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Peminjaman',
            'page_title' => 'Tambah Peminjaman',
            'breadcrumb' => 'Tambah Peminjaman',
            'members' => $this->memberModel->findAll(),
            'books' => $this->bookModel->findAll(),
        ];
        return view('peminjaman/form', $data);
    }

    public function store()
    {
        $this->borrowingModel->insert([
            'member_id'   => $this->request->getPost('member_id'),
            'book_id'     => $this->request->getPost('book_id'),
            'borrow_date' => date('Y-m-d'), // otomatis hari ini
            'qty'         => $this->request->getPost('qty'),
            'return_date' => $this->request->getPost('return_date'),
            'status'      => 'Dipinjam',
        ]);
        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function returnBook($id)
    {
        $this->borrowingModel->update($id, [
            'status' => 'Dikembalikan',
            'return_date' => date('Y-m-d'),
        ]);
        return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dikembalikan');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Peminjaman',
            'page_title' => 'Edit Peminjaman',
            'breadcrumb' => 'Peminjaman / Edit',
            'peminjaman' => $this->borrowingModel->find($id),
            'members'    => $this->memberModel->findAll(),
            'books'      => $this->bookModel->findAll()
        ];

        return view('peminjaman/form_edit', $data);
    }


    public function update($id)
    {
        $data = [
            'member_id'   => $this->request->getPost('member_id'),
            'book_id'     => $this->request->getPost('book_id'),
            'qty'         => $this->request->getPost('qty'),
            'borrow_date' => $this->request->getPost('borrow_date'),
            'return_date' => $this->request->getPost('return_date'),
            'status'      => $this->request->getPost('status'),
        ];

        $this->borrowingModel->update($id, $data);

        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->borrowingModel->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil dihapus');
    }
}

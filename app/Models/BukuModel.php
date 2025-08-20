<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'title',
        'author',
        'publisher',
        'publish_year',
        'category_id',
        'stock',
        'location'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'title'        => 'required|min_length[3]',
        'author'       => 'permit_empty|string',
        'publisher'    => 'permit_empty|string',
        'publish_year' => 'required|numeric|exact_length[4]',
        'category_id'  => 'required|is_natural_no_zero',
        'stock'        => 'required|integer',
        'location'     => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul buku wajib diisi',
            'min_length' => 'Judul minimal 3 karakter'
        ],
        'publish_year' => [
            'required' => 'Tahun terbit wajib diisi',
            'numeric'  => 'Tahun harus berupa angka',
            'exact_length' => 'Tahun harus 4 digit'
        ],
        'category_id' => [
            'required' => 'Kategori wajib dipilih'
        ],
        'stock' => [
            'required' => 'Stok wajib diisi',
            'integer'  => 'Stok harus berupa angka'
        ],
        'location' => [
            'required' => 'Letak buku harus diisi'
        ]
    ];

        public function getBukuWithCategory()
    {
        return $this->select('books.*, categories.name AS category_name')
                    ->join('categories', 'books.category_id = categories.id')
                    ->findAll();
    }
}

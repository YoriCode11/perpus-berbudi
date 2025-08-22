<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Kitab', 'description' => null],
            ['id' => 2, 'name' => 'Ilmu Pengetahuan', 'description' => null],
            ['id' => 3, 'name' => 'Novel', 'description' => null],
            ['id' => 4, 'name' => 'Edukasi', 'description' => null],
            ['id' => 5, 'name' => 'Ensiklopedia', 'description' => null],
            ['id' => 6, 'name' => 'Biografi', 'description' => null],
            ['id' => 7, 'name' => 'Cerpen', 'description' => null],
            ['id' => 8, 'name' => 'Ilmu Pengetahuan (Typo)', 'description' => null],
            ['id' => 9, 'name' => 'Panduan', 'description' => null],
            ['id' => 10, 'name' => 'Syair Puisi', 'description' => null],
            ['id' => 11, 'name' => 'Kamus', 'description' => null],
            ['id' => 12, 'name' => 'Dongeng', 'description' => null],
            ['id' => 13, 'name' => 'Komik', 'description' => null],
            ['id' => 14, 'name' => 'Buku Pelajaran', 'description' => null],
            ['id' => 15, 'name' => 'Majalah', 'description' => null],
            ['id' => 16, 'name' => 'Jurnal', 'description' => null],
            ['id' => 17, 'name' => 'Edkukasi', 'description' => null],
            ['id' => 18, 'name' => 'Ilmu Pengetauan', 'description' => null],
            ['id' => 19, 'name' => 'Syair', 'description' => null],
            ['id' => 20, 'name' => 'Non Fiksi', 'description' => null],
            ['id' => 21, 'name' => 'Aesiaonisiusa', 'description' => null],
            ['id' => 22, 'name' => 'Lngeya Nusah', 'description' => null],
            ['id' => 23, 'name' => 'EelDrawega', 'description' => null],
            ['id' => 24, 'name' => 'Eltimediaetata', 'description' => null],
            ['id' => 25, 'name' => 'Cerita', 'description' => null],
            ['id' => 26, 'name' => 'Cerita Rakyat', 'description' => null],
            ['id' => 27, 'name' => 'Legenda', 'description' => null],
            ['id' => 28, 'name' => 'Sejarah', 'description' => null],
            ['id' => 29, 'name' => 'Puisi', 'description' => null],
            ['id' => 30, 'name' => 'Psnduan', 'description' => null],
            ['id' => 32, 'name' => 'Fiksi Remaja', 'description' => null],
            ['id' => 33, 'name' => 'Atlas', 'description' => null],
            ['id' => 35, 'name' => 'aaaaaaa', 'description' => 'aaaaa'],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UbahKolomAnggotaJurusan extends Migration
{
    public function up()
    {
        // 1. Hapus kolom 'alamat'
        $this->forge->dropColumn('anggota', 'alamat');

        // 2. Tambahkan kolom 'jurusan'
        $fields = [
            'jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', // Sesuaikan panjang constraint jika perlu
                'null'       => true, // Sesuaikan apakah kolom ini boleh null atau tidak
            ],
        ];
        $this->forge->addColumn('anggota', $fields);
    }

    public function down()
    {
        // Dalam metode down, kita kembalikan ke kondisi semula (opsional, tapi baik untuk rollback)
        // Hapus kolom 'jurusan'
        $this->forge->dropColumn('anggota', 'jurusan');

        // Tambahkan kembali kolom 'alamat'
        $fields = [
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('anggota', $fields);
    }
}
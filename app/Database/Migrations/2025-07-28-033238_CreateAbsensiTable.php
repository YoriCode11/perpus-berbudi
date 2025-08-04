<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_anggota' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'tanggal_masuk' => [
                'type'       => 'DATETIME',
            ],
            'tanggal_keluar' => [
                'type'       => 'DATETIME',
                'null'       => true, // Bisa null karena awalnya belum keluar
            ],
            'status' => [ // misal: 'masuk', 'keluar'
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'masuk',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        // Foreign Key ke tabel anggota
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
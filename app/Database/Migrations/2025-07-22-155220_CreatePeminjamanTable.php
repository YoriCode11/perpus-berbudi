<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjamanTable extends Migration
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
            'id_buku' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'tanggal_pinjam' => [
                'type'       => 'DATETIME',
            ],
            'tanggal_kembali' => [
                'type'       => 'DATETIME',
                'null'       => true, // Bisa null karena awalnya belum dikembalikan
            ],
            'status' => [ // misal: 'dipinjam', 'kembali'
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'dipinjam',
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
        // Foreign Key ke tabel buku
        $this->forge->addForeignKey('id_buku', 'buku', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}

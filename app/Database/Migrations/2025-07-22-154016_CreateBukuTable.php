<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'penulis' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'penerbit' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tahun_terbit' => [
                'type'       => 'YEAR',
                'constraint' => 4,
            ],
            'id_kategori' => [ // Foreign Key
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
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
        // Tambahkan foreign key constraint
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
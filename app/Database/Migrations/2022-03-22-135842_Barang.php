<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        // tabel users
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 7,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('barang');
    }

    public function down()
    {
        // hapus tabel barang
        $this->forge->dropTable('barang');
    }
}

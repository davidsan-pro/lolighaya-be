<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDTransaction extends Migration
{
    private $tblname = 'd_transaksi';

    public function up()
    {
        // tabel detail transaksi
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'id_barang'    => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'harga'        => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
                'default'    => 0,
            ],
            'titip'        => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => false,
                'default'    => 0,
            ],
            'sisa'         => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => false,
                'default'    => 0,
            ],
            'laku'         => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => false,
                'default'    => 0,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->tblname);
    }

    public function down()
    {
        // hapus tabel detail barang
        $this->forge->dropTable($this->tblname);
    }
}

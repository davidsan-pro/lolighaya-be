<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDRute extends Migration
{
    private $tblname = 'd_rute';

    public function up()
    {
        // tabel detail rute
        $this->forge->addField([
            'id'      => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'id_rute' => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'id_toko' => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->tblname);
    }

    public function down()
    {
        // hapus tabel detail rute
        $this->forge->dropTable($this->tblname);
    }
}

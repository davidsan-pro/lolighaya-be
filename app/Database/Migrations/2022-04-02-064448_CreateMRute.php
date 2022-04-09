<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMRute extends Migration
{
    private $tblname = 'm_rute';

    public function up()
    {
        // tabel master rute
        $this->forge->addField([
            'id'        => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'nama_rute' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
            ],
            'hari'      => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
                'default'    => 1,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->tblname);
    }

    public function down()
    {
        // hapus tabel master rute
        $this->forge->dropTable($this->tblname);
    }
}

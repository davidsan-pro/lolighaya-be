<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBarangAddFotoAndUpdatedAt extends Migration
{
    private $tblname = 'barang';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ["foto", "updated_at"]);
    }
}

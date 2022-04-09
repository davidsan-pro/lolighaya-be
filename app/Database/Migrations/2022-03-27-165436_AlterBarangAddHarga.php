<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBarangAddHarga extends Migration
{
    private $tblname = 'barang';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'harga' => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ["foto", "updated_at"]);
    }
}

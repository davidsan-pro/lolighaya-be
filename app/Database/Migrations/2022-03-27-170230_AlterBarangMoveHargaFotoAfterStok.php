<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBarangMoveHargaFotoAfterStok extends Migration
{
    private $tblname = 'barang';

    public function up()
    {
        $this->forge->dropColumn($this->tblname, ['foto', 'harga']);

        $this->forge->addColumn($this->tblname, [
            'foto'  => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
                'after'      => 'stok',
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 7,
                'default'    => 0,
                'after'      => 'stok',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}

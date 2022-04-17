<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDruteAddUrutan extends Migration
{
    private $tblname = 'd_rute';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'urutan' => [
                'type'       => 'SMALLINT',
                'constraint' => 3,
                'null'       => false,
                'default'    => 0,
                'after'      => 'id_rute',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ['urutan']);
    }
}

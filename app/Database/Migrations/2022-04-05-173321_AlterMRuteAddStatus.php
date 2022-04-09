<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMRuteAddStatus extends Migration
{
    private $tblname = 'm_rute';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'hari',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ["status"]);
    }
}

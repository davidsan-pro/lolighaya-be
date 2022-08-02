<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddLevel extends Migration
{
    private $tblname = 'users';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'level' => [
                'type'       => 'SMALLINT',
                'constraint' => 3,
                'null'       => false,
                'default'    => 1,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ['level']);
    }
}

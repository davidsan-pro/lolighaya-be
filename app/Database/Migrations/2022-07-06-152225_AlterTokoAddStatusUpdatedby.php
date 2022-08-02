<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTokoAddStatusUpdatedby extends Migration
{
    private $tblname = 'toko';

    public function up()
    {
        $this->forge->addColumn($this->tblname, [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'telepon',
            ],
            'updated_by_user_id' => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => true,
                'after'      => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tblname, ['status', 'updated_by_user_id']);
    }
}

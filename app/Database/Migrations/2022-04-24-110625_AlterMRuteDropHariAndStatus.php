<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMRuteDropHariAndStatus extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('m_rute', ["hari", "status"]);
    }

    public function down()
    {
        //
    }
}

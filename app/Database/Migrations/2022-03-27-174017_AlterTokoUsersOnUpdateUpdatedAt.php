<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTokoUsersOnUpdateUpdatedAt extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn(
            'toko',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );
        $this->forge->modifyColumn(
            'users',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        );
    }

    public function down()
    {
        $this->forge->modifyColumn(
            'toko',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        );
        $this->forge->modifyColumn(
            'users',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        );
    }
}

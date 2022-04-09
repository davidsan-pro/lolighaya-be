<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        // tabel users
        $this->forge->addField([
            'id'       => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'email'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'foto'     => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama'     => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'telepon'  => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        // hapus tabel users
        $this->forge->dropTable('users');
    }
}

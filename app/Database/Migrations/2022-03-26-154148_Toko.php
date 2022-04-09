<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Toko extends Migration
{
    public function up()
    {
        // tabel toko
        $this->forge->addField([
            'id'        => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'alamat'    => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'foto'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'kota'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'telepon'   => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('toko');
    }

    public function down()
    {
        // hapus tabel toko
        $this->forge->dropTable('toko');
    }
}

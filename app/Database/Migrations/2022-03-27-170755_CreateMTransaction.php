<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMTransaction extends Migration
{
    private $tblname = 'm_transaksi';

    public function up()
    {
        // tabel master transaksi
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'constraint'     => 7,
                'auto_increment' => true,
            ],
            'id_toko'         => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'id_user'         => [
                'type'       => 'INT',
                'constraint' => 7,
                'null'       => false,
            ],
            'jenis_transaksi' => [
                'type'       => 'ENUM',
                'constraint' => ['kunjungan_toko', 'komisi_user'],
                'default'    => 'kunjungan_toko',
            ],
            'nilai_transaksi' => [
                'type'       => 'INT',
                'constraint' => 10,
                'null'       => false,
                'default'    => 0,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->tblname);
    }

    public function down()
    {
        // hapus tabel master transaction
        $this->forge->dropTable($this->tblname);
    }
}

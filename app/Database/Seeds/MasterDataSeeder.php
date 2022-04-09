<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        $this->call('BarangSeeder');
        $this->call('UsersSeeder');
        $this->call('TokoSeeder');
        $this->call('MRuteSeeder');
        $this->call('DRuteSeeder');
    }
}
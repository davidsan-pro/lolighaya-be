<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RuteSeeder extends Seeder
{
    public function run()
    {
        $this->call('MRuteSeeder');
        $this->call('DRuteSeeder');
    }
}
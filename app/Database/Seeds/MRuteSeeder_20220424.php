<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MRuteSeeder_20220424 extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'nama_rute' => 'AAA',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('m_rute')->insertBatch($data);
    }
}

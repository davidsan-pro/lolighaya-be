<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MRuteSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'nama_rute' => 'AAA',
                'hari' => 1,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 2,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 3,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 4,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 5,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 6,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'AAA',
                'hari' => 7,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 1,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 2,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 3,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 4,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 5,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 6,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'BBB',
                'hari' => 7,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 1,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 2,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 3,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 4,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 5,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 6,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_rute' => 'CCC',
                'hari' => 7,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('m_rute')->insertBatch($data);
    }
}

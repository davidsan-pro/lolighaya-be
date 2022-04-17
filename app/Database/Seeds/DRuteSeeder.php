<?php

namespace App\Database\Seeds;

// use App\Models\TokoModel;
use CodeIgniter\Database\Seeder;

class DRuteSeeder extends Seeder
{
    public function run()
    {
        // $mymodel = new TokoModel;
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'id_rute' => 1,
                'urutan' => 1,
                'id_toko' => 1,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_rute' => 1,
                'urutan' => 2,
                'id_toko' => 2,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_rute' => 1,
                'urutan' => 3,
                'id_toko' => 3,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_rute' => 1,
                'urutan' => 4,
                'id_toko' => 4,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'id_rute' => 2,
                'urutan' => 1,
                'id_toko' => 3,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_rute' => 2,
                'urutan' => 2,
                'id_toko' => 4,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_rute' => 2,
                'urutan' => 3,
                'id_toko' => 5,
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('d_rute')->insertBatch($data);
    }
}

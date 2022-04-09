<?php

namespace App\Database\Seeds;

// use App\Models\BarangModel;
use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        // $mymodel = new BarangModel;
        $faker = \Faker\Factory::create('id_ID');

        $data = [];
        $data = [
            [
                'nama'       => 'lolipop vanilla',
                'stok'       => 300,
                'harga'      => 5000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'lolipop jeruk strawberry',
                'stok'       => 350,
                'harga'      => 6000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'lolipop nanas',
                'stok'       => 250,
                'harga'      => 6000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'permen coklat',
                'stok'       => 300,
                'harga'      => 3000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'permen sugus',
                'stok'       => 300,
                'harga'      => 3000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'balon kecil isi 12',
                'stok'       => 200,
                'harga'      => 10000,
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('barang')->insertBatch($data);
    }
}

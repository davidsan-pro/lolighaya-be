<?php

namespace App\Database\Seeds;

// use App\Models\TokoModel;
use CodeIgniter\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run()
    {
        // $mymodel = new TokoModel;
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'nama'       => 'Toko Barokah',
                'alamat'     => $faker->streetAddress(),
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'foto'       => '',
                'kota'       => 'surabaya',
                'kecamatan'  => 'rungkut',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Toko Sinar Terang',
                'alamat'     => $faker->streetAddress(),
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'foto'       => '',
                'kota'       => 'surabaya',
                'kecamatan'  => 'rungkut',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Toko Sumber Jaya',
                'alamat'     => $faker->streetAddress(),
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'foto'       => '',
                'kota'       => 'surabaya',
                'kecamatan'  => 'kenjeran',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Toko Rejeki',
                'alamat'     => $faker->streetAddress(),
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'foto'       => '',
                'kota'       => 'sidoarjo',
                'kecamatan'  => 'candi',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Toko Sumber Makmur',
                'alamat'     => $faker->streetAddress(),
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'foto'       => '',
                'kota'       => 'sidoarjo',
                'kecamatan'  => 'buduran',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('toko')->insertBatch($data);
    }
}

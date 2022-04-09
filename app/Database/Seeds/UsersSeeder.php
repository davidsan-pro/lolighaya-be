<?php

namespace App\Database\Seeds;

// use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // $usermodel = new UserModel;
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'username'   => 'admin01',
                'nama'       => 'pak bos',
                'email'      => 'edytnj@gmail.com',
                'telepon'    => '08123123111',
                'password'   => 'abc123456',
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'admin02',
                'nama'       => 'administrator',
                'email'      => 'adminlolighaya01@gmail.com',
                'telepon'    => '08123123222',
                'password'   => 'abc123456',
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'sales01',
                'nama'       => 'edy tanujaya',
                'email'      => 'edytnj@gmail.com',
                'telepon'    => '08123123333',
                'password'   => 'abc123456',
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        for ($i = 2; $i <= 5; $i++) {
            $data[] = [
                'username'   => 'sales' . str_pad($i, 2, "0", STR_PAD_LEFT),
                'nama'       => $faker->name,
                'email'      => $faker->email,
                'telepon'    => '08' . $faker->numberBetween(1000000000, 1999999999),
                'password'   => 'abc123456',
                'foto'       => '',
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime()),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Using Query Builder
        // $this->db->table('users')->insert($data);
        $this->db->table('users')->insertBatch($data);
    }
}

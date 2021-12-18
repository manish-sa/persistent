<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new UserModel;
        $faker = \Faker\Factory::create();
        $user->save(
            [
                'username' => $faker->username,
                'password' => password_hash($faker->password, PASSWORD_DEFAULT),
            ]
        );
    }
}

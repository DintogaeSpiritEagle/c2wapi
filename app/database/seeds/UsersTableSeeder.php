<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'C2WApi Admin',
                'email'          => 'admin@c2wapi.com',
                'password'       => bcrypt('c2w@p1'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'C2WApi User',
                'email'          => 'user@c2wapi.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Admin User 2',
                'email'          => 'admin2@unleash23.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);

    }
}

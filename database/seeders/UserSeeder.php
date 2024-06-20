<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'user@mail.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
            ],
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('passwordAdmin'),
                'role_id' => 1,
            ],
            [
                'name' => 'user',
                'email' => 'angelop.casapaico@gmail.com',
                'password' => bcrypt('passwordUser'),
                'role_id' => 2,
            ],
        ];

        foreach ($users as $user) {
            $newUser = new User();
            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->password = $user['password'];
            $newUser->role_id = $user['role_id'];

            $newUser->save();
        }
    }
}

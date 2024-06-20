<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Usuario'],
        ];

        foreach ($roles as $role) {
            $newRole = new Role();
            $newRole->name = $role['name'];

            $newRole->save();
        }
    }
}

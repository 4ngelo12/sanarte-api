<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            ['name' => 'Activo'],
            ['name' => 'Completado'],
            ['name' => 'Cancelado'],
        ];

        foreach ($status as $state) {
            $newStatus = new Status();
            $newStatus->name = $state['name'];

            $newStatus->save();
        }
    }
}

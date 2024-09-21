<?php

namespace Database\Seeders;

use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Personal = [
            [
                'name' => 'Juan',
                'lastname' => 'Perez',
                'phone' => '900123651',
                'status' => 1,
                'service_id' => 1,
            ],
            [
                'name' => 'Rosa',
                'lastname' => 'Martinez',
                'phone' => '922323651',
                'status' => 1,
                'service_id' => 2,
            ],
            [
                'name' => 'Andrea',
                'lastname' => 'Cruz',
                'phone' => '900123023',
                'status' => 1,
                'service_id' => 3,
            ],
            [
                'name' => 'Maria',
                'lastname' => 'Gomez',
                'phone' => '901983651',
                'status' => 1,
                'service_id' => 3,
            ],
            [
                'name' => 'Araceli',
                'lastname' => 'Palacios',
                'phone' => '900321651',
                'status' => 1,
                'service_id' => 1,
            ],
            [
                'name' => 'Daniela',
                'lastname' => 'Garcia',
                'phone' => '900129807',
                'status' => 1,
                'service_id' => 4,
            ], 
        ];

        foreach ($Personal as $personal) {
            $newPersonal = new Personal();
            $newPersonal->name = $personal['name'];
            $newPersonal->lastname = $personal['lastname'];
            $newPersonal->phone = $personal['phone'];
            $newPersonal->status = $personal['status'];
            $newPersonal->service_id = $personal['service_id'];

            $newPersonal->save();
        }
    }
}

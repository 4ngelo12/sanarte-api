<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Rosa ',
                'lastname' => 'Gutierrez',
                'phone' => '987654321',
                'state' => 1,
            ],
            [
                'name' => 'Andrea ',
                'lastname' => 'Gutierrez',
                'phone' => '902584162',
                'state' => 1,
            ],
            [
                'name' => 'Raquel',
                'lastname' => 'Valencia',
                'phone' => '987654371',
                'state' => 1,
            ],
            [
                'name' => 'Diana',
                'lastname' => 'Cruz',
                'phone' => '987114371',
                'state' => 1,
            ],
        ];

        foreach ($clients as $client) {
            $newClient = new Client();
            $newClient->name = $client['name'];
            $newClient->lastname = $client['lastname'];
            isset($client['email']) ? $newClient->email = $client['email'] : null;
            $newClient->phone = $client['phone'];
            $newClient->state = $client['state'];

            $newClient->save();
        }
    }
}

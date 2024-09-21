<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Reservation = [
            [
                'date_reservation' => '2024-05-20',
                'time_reservation' => '16:00',
                'status_id' => 2,
                'client_id' => 1,
                'service_id' => 1,
                'personal_id' => 1,
                'user_id' => 1,
            ],
            [
                'date_reservation' => '2024-05-20',
                'time_reservation' => '14:00',
                'status_id' => 2,
                'client_id' => 2,
                'service_id' => 2,
                'personal_id' => 2,
                'user_id' => 1,
            ],
            [
                'date_reservation' => '2024-05-22',
                'time_reservation' => '16:00',
                'status_id' => 3,
                'client_id' => 3,
                'service_id' => 3,
                'personal_id' => 3,
                'user_id' => 1,
            ],
            [
                'date_reservation' => '2024-05-22',
                'time_reservation' => '13:00',
                'status_id' => 2,
                'client_id' => 1,
                'service_id' => 3,
                'personal_id' => 4,
                'user_id' => 1,
            ],
            [
                'date_reservation' => '2024-05-24',
                'time_reservation' => '15:40',
                'status_id' => 3,
                'client_id' => 3,
                'service_id' => 1,
                'personal_id' => 5,
                'user_id' => 1,
            ],
            [
                'date_reservation' => '2024-05-29',
                'time_reservation' => '15:20',
                'status_id' => 2,
                'client_id' => 2,
                'service_id' => 4,
                'personal_id' => 6,
                'user_id' => 2,
            ],
        ];

        foreach ($Reservation as $reservation) {
            $newReservation = new Reservation();
            $newReservation->date_reservation = $reservation['date_reservation'];
            $newReservation->time_reservation = $reservation['time_reservation'];
            $newReservation->status_id = $reservation['status_id'];
            $newReservation->client_id = $reservation['client_id'];
            $newReservation->service_id = $reservation['service_id'];
            $newReservation->personal_id = $reservation['personal_id'];
            $newReservation->user_id = $reservation['user_id'];

            $newReservation->save();
        }
    }
}

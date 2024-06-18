<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = "reservations";

    protected $fillable = [
        'date_reservation',
        'time_reservation',
        'status_id',
        'user_id',
        'client_id',
        'service_id'
    ];

    public function getTimeReservationAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
}

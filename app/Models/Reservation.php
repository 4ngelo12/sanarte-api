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
        'service_id',
        'personal_id' 
    ];

    protected $appends = ['user_name', 'client_name', 'service_name', 'personal_name', 'status_name'];

    protected $hidden = [
        'client',
        'service',
        'personal',
        'user',
        'status',
        "created_at",
        "updated_at"
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getClientNameAttribute()
    {
        return $this->client->name . ' ' . $this->client->lastname;
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getServiceNameAttribute()
    {
        return $this->service->name;
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function getPersonalNameAttribute()
    {
        return $this->personal->name . ' ' . $this->personal->lastname;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getStatusNameAttribute()
    {
        return $this->status->name;
    }

    public function getTimeReservationAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
}

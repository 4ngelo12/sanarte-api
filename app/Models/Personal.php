<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = "personal";

    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'status',
        'service_id'
    ];

    protected $appends = ['service_name'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getServiceNameAttribute()
    {
        return $this->service->name;
    }

    protected $hidden = [
        'service',
        "created_at",
        "updated_at"
    ];
}

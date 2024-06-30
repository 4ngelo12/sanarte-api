<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = "services";

    protected $fillable = [
        'name',
        'description',
        // 'image',
        'price',
        'state',
        'duration',
        'category_id'
    ];

    protected $appends = ['category_name'];
    
    protected $casts = [
        'duration' => 'array' // Indica que 'duration' se debe tratar como un arreglo al guardar y recuperar datos
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    protected $hidden = [
        'category',
        "created_at",
        "updated_at"
    ];

   
}

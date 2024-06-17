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
        'image',
        'price',
        'state',
        'duration',
        'category_id'
    ];
    
    protected $casts = [
        'duration' => 'array' // Indica que 'duration' se debe tratar como un arreglo al guardar y recuperar datos
    ];
}

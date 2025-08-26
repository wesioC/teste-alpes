<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $table = 'carros';

    protected $fillable = [
        'id',
        'type',
        'brand',
        'model',
        'version',
        'year_model',
        'year_build',
        'optionals',
        'doors',
        'board',
        'chassi',
        'transmission',
        'km',
        'description',
        'sold',
        'category',
        'url_car',
        'old_price',
        'price',
        'color',
        'fuel',
        'fotos',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

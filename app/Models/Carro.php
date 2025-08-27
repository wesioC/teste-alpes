<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carro extends Model
{
    use HasFactory;
    
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
    ];

    protected $casts = [
        'optionals' => 'array',
        'fotos'     => 'array',
        'sold'      => 'boolean',
    ];

    public function setYearAttribute($value)
    {
        $this->attributes['year_model'] = $value['model'] ?? null;
        $this->attributes['year_build'] = $value['build'] ?? null;
    }

    public function getYearAttribute()
    {
        return [
            'model' => $this->year_model,
            'build' => $this->year_build,
        ];
    }
}

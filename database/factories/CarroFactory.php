<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Carro;

class CarroFactory extends Factory
{
    protected $model = Carro::class;

    public function definition()
    {
        return [
            'type' => 'carro',
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'version' => $this->faker->word,
            'year_model' => $this->faker->year,
            'year_build' => $this->faker->year,
            'optionals' => [],
            'doors' => 4,
            'board' => strtoupper($this->faker->bothify('???###')),
            'chassi' => '',
            'transmission' => 'Automática',
            'km' => $this->faker->numberBetween(1000,50000),
            'description' => $this->faker->sentence,
            'sold' => false,
            'category' => 'SUV',
            'url_car' => $this->faker->slug,
            'price' => $this->faker->randomFloat(2, 20000, 150000),
            'color' => $this->faker->safeColorName,
            'fuel' => 'Gasolina',
            'fotos' => [],
        ];
    }
}

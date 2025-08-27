<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'brand'       => $this->brand,
            'model'       => $this->model,
            'version'     => $this->version,
            'year' => [
                'model' => $this->year_model,
                'build' => $this->year_build,
            ],
            'optionals'   => $this->optionals,
            'doors'       => $this->doors,
            'board'       => $this->board,
            'chassi'      => $this->chassi,
            'transmission'=> $this->transmission,
            'km'          => $this->km,
            'description' => $this->description,
            'sold'        => $this->sold,
            'category'    => $this->category,
            'url_car'     => $this->url_car,
            'old_price'   => $this->old_price,
            'price'       => $this->price,
            'color'       => $this->color,
            'fuel'        => $this->fuel,
            'fotos'       => $this->fotos,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'version' => 'sometimes|required|string|max:255',
            'year.model' => 'sometimes|required|integer',
            'year.build' => 'sometimes|required|integer',
            'optionals' => 'nullable|array',
            'doors' => 'sometimes|required|integer',
            'board' => 'sometimes|required|string|max:255',
            'chassi' => 'nullable|string|max:255',
            'transmission' => 'sometimes|required|string|max:255',
            'km' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'sold' => 'sometimes|required|boolean',
            'category' => 'sometimes|required|string|max:255',
            'url_car' => 'sometimes|required|string|max:255',
            'old_price' => 'nullable|numeric',
            'price' => 'sometimes|required|numeric',
            'color' => 'sometimes|required|string|max:255',
            'fuel' => 'sometimes|required|string|max:255',
            'fotos' => 'nullable|array',
        ];
    }

}

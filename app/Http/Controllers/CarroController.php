<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carro;
use App\Http\Resources\CarroResource;
use App\Http\Requests\CarroRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CarroController extends Controller
{

    public function index()
    {
        return CarroResource::collection(Carro::all());
    }


    public function store(CarroRequest $request)
    {
        $carro = Carro::create($request->validated());
        if (!$carro) {
            return response()->json(['message' => 'Error creating car'], 500);
        }
        return response()->json($carro, 201);
    }


    public function show(string $id)
    {
        $carro = Carro::find($id);
        if (!$carro) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        return new CarroResource($carro);
    }


    public function update(CarroRequest $request, string $id)
    {
        $carro = Carro::find($id);
        if (!$carro) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $data = $request->validated();
        $data['year_model'] = $data['year']['model'] ?? $carro->year_model;
        $data['year_build'] = $data['year']['build'] ?? $carro->year_build;
        unset($data['year']);
        $carro->update($data);
        return response()->json($carro);
    }


    public function destroy(string $id)
    {
        $carro = Carro::find($id);
        if (!$carro) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $carro->delete();
        return response()->json(null, 204);
    }
}

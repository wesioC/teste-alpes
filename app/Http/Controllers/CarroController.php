<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carro;
use Illuminate\Http\JsonResponse;

class CarroController extends Controller
{

    public function index()
    {
        $carros = Carro::all();
        return response()->json($carros);
    }


    public function store(Request $request)
    {
        $carro = Carro::create($request->all());
        return response()->json($carro, 201);
    }


    public function show(string $id)
    {
        $carro = Carro::find($id);
        if (!$carro) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        return response()->json($carro);
    }


    public function update(Request $request, string $id)
    {
        $carro = Carro::find($id);
        if (!$carro) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $carro->update($request->all());
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

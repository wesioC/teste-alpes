<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarroController;

Route::apiResource('cars', CarroController::class);

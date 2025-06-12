<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Mantener solo la ruta de usuario para autenticación futura
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Las rutas de API REST han sido migradas a Inertia.js
// Todas las rutas ahora están en routes/web.php

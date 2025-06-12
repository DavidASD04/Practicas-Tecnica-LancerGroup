<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Inertia\Inertia;

// Ruta principal - Dashboard
Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'stats' => [
            'authors' => \App\Models\Author::count(),
            'books' => \App\Models\Book::count(),
        ]
    ]);
})->name('dashboard');

// Ruta de prueba para verificar navegación
Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');

// Ruta de prueba para formularios
Route::get('/test-form', function () {
    return Inertia::render('TestForm');
})->name('test-form');

// Ruta de debug simple
Route::get('/debug', function () {
    return response()->json([
        'message' => 'Laravel está funcionando correctamente',
        'inertia_version' => '1.0.0',
        'authors_count' => \App\Models\Author::count(),
        'books_count' => \App\Models\Book::count(),
    ]);
})->name('debug');

// Ruta de prueba simple para Inertia
Route::get('/simple-test', function () {
    return Inertia::render('SimpleTest');
})->name('simple-test');

// Ruta HTML simple para verificar
Route::get('/html-test', function () {
    return '<!DOCTYPE html><html><body><h1>HTML simple funciona</h1><p>Laravel está enviando contenido</p></body></html>';
})->name('html-test');

// Debug de Inertia más detallado
Route::get('/inertia-debug', function () {
    try {
        $response = Inertia::render('SimpleTest');
        return response()->json([
            'status' => 'Inertia funcionando',
            'response_type' => get_class($response),
            'content' => $response->getContent(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
})->name('inertia-debug');

// Test básico sin Vuetify
Route::get('/basic-test', function () {
    return Inertia::render('BasicTest');
})->name('basic-test');

// Ver HTML crudo que genera Inertia
Route::get('/view-source', function () {
    $response = Inertia::render('BasicTest');
    return response($response->getContent())
        ->header('Content-Type', 'text/plain');
})->name('view-source');

// Rutas de autores usando Inertia
Route::resource('authors', AuthorController::class);

// Rutas de libros usando Inertia
Route::resource('books', BookController::class);

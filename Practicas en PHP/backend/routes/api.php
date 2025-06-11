<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authors routes
Route::apiResource('authors', AuthorController::class);

// Books routes
Route::apiResource('books', BookController::class);
Route::get('books-authors', [BookController::class, 'getAuthorsForSelect']);

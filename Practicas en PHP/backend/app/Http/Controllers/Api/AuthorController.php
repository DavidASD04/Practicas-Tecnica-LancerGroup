<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::with('books')
            ->select(['id', 'nombre', 'apellido', 'pais', 'fecha_registro', 'created_at', 'updated_at'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }

    public function show(Author $author): JsonResponse
    {
        $author->load('books');
        
        return response()->json([
            'success' => true,
            'data' => $author
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
            ]);

            $author = Author::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Autor creado exitosamente',
                'data' => $author
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, Author $author): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
            ]);

            $author->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Autor actualizado exitosamente',
                'data' => $author
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Autor eliminado exitosamente'
        ]);
    }
}

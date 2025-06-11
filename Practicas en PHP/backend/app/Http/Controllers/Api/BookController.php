<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $books = Book::with('authors')
            ->select(['id', 'nombre', 'fecha_publicacion', 'edicion', 'created_at', 'updated_at'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function show(Book $book): JsonResponse
    {
        $book->load('authors');
        
        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_publicacion' => 'required|date',
                'edicion' => 'required|string|max:255',
                'authors' => 'required|array|min:1',
                'authors.*' => 'exists:authors,id'
            ]);

            $book = Book::create([
                'nombre' => $validated['nombre'],
                'fecha_publicacion' => $validated['fecha_publicacion'],
                'edicion' => $validated['edicion'],
            ]);

            $book->authors()->attach($validated['authors']);
            $book->load('authors');

            return response()->json([
                'success' => true,
                'message' => 'Libro creado exitosamente',
                'data' => $book
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_publicacion' => 'required|date',
                'edicion' => 'required|string|max:255',
                'authors' => 'required|array|min:1',
                'authors.*' => 'exists:authors,id'
            ]);

            $book->update([
                'nombre' => $validated['nombre'],
                'fecha_publicacion' => $validated['fecha_publicacion'],
                'edicion' => $validated['edicion'],
            ]);

            $book->authors()->sync($validated['authors']);
            $book->load('authors');

            return response()->json([
                'success' => true,
                'message' => 'Libro actualizado exitosamente',
                'data' => $book
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Libro eliminado exitosamente'
        ]);
    }

    public function getAuthorsForSelect(): JsonResponse
    {
        $authors = Author::select(['id', 'nombre', 'apellido'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }
}

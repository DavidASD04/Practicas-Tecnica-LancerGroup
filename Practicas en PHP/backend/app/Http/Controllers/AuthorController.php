<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount('books')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($author) {
                return [
                    'id' => $author->id,
                    'nombre' => $author->nombre,
                    'apellido' => $author->apellido,
                    'nombre_completo' => $author->nombre_completo,
                    'pais' => $author->pais,
                    'fecha_registro' => $author->fecha_registro,
                    'cantidad_libros' => $author->books_count,
                    'created_at' => $author->created_at,
                    'updated_at' => $author->updated_at,
                ];
            });

        return Inertia::render('Authors/Index', [
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Authors/Create');
    }    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log what we're receiving
        \Log::info('AuthorController store() called', [
            'method' => $request->method(),
            'all_data' => $request->all(),
        ]);

        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
            ]);

            \Log::info('Validation passed', $validated);

            $author = Author::create($validated);

            \Log::info('Author created', ['author_id' => $author->id]);

            return Redirect::route('authors.index')
                ->with('success', 'Autor creado exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error creating author', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Error al crear el autor: ' . $e->getMessage()]);
        }
    }    /**
     * Display the specified resource.
     */
    public function show(Request $request, Author $author)
    {
        $author->load('books');

        $authorData = [
            'id' => $author->id,
            'nombre' => $author->nombre,
            'apellido' => $author->apellido,
            'nombre_completo' => $author->nombre_completo,
            'pais' => $author->pais,
            'fecha_registro' => $author->fecha_registro,
            'cantidad_libros' => $author->cantidad_libros,
            'books' => $author->books->map(function ($book) {
                return [
                    'id' => $book->id,
                    'nombre' => $book->nombre,
                    'fecha_publicacion' => $book->fecha_publicacion,
                    'edicion' => $book->edicion,
                ];
            }),
            'created_at' => $author->created_at,
            'updated_at' => $author->updated_at,
        ];

        // Si es una petición AJAX, retornar JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'props' => [
                    'author' => $authorData
                ]
            ]);
        }

        // Si es una petición normal, retornar la vista
        return Inertia::render('Authors/Show', [
            'author' => $authorData
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return Inertia::render('Authors/Edit', [
            'author' => [
                'id' => $author->id,
                'nombre' => $author->nombre,
                'apellido' => $author->apellido,
                'pais' => $author->pais,
            ]
        ]);
    }    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // Debug: Log what we're receiving
        \Log::info('AuthorController update() called', [
            'author_id' => $author->id,
            'all_data' => $request->all(),
        ]);

        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
            ]);

            \Log::info('Validation passed', $validated);

            $author->update($validated);

            \Log::info('Author updated', ['author_id' => $author->id]);

            return Redirect::route('authors.index')
                ->with('success', 'Autor actualizado exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error updating author', [
                'author_id' => $author->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Error al actualizar el autor: ' . $e->getMessage()]);
        }
    }    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        \Log::info('AuthorController destroy() called', ['author_id' => $author->id]);

        try {
            $author->delete();

            \Log::info('Author deleted', ['author_id' => $author->id]);

            return Redirect::route('authors.index')
                ->with('success', 'Autor eliminado exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error deleting author', [
                'author_id' => $author->id,
                'error' => $e->getMessage(),
            ]);
            
            return back()->withErrors(['error' => 'Error al eliminar el autor: ' . $e->getMessage()]);
        }
    }
}

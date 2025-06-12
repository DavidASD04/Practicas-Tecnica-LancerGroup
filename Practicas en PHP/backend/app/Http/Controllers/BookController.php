<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'nombre' => $book->nombre,
                    'fecha_publicacion' => $book->fecha_publicacion?->format('Y-m-d'),
                    'edicion' => $book->edicion,
                ];
            });

        return Inertia::render('Books/Index', [
            'books' => $books
        ]);
    }    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::orderBy('nombre')
            ->get()
            ->map(function ($author) {
                return [
                    'id' => $author->id,
                    'nombre' => $author->nombre,
                    'apellido' => $author->apellido,
                    'nombre_completo' => $author->nombre . ' ' . $author->apellido,
                ];
            });

        return Inertia::render('Books/Create', [
            'authors' => $authors
        ]);
    }/**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log what we're receiving
        \Log::info('BookController store() called', [
            'method' => $request->method(),
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
        ]);        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_publicacion' => 'nullable|date',
                'edicion' => 'nullable|string|max:100',
                'authors' => 'required|array|min:1',
                'authors.*' => 'exists:authors,id'
            ], [
                'authors.required' => 'Debes seleccionar al menos un autor para el libro.',
                'authors.min' => 'Debes seleccionar al menos un autor para el libro.',
            ]);

            \Log::info('Validation passed', $validated);

            $book = Book::create($validated);

            \Log::info('Book created', ['book_id' => $book->id]);

            if (!empty($validated['authors'])) {
                $book->authors()->attach($validated['authors']);
                \Log::info('Authors attached', ['authors' => $validated['authors']]);
            }

            return Redirect::route('books.index')
                ->with('success', 'Libro creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error creating book', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Error al crear el libro: ' . $e->getMessage()]);
        }
    }    /**
     * Display the specified resource.
     */
    public function show(Request $request, Book $book)
    {
        $book->load('authors');

        $bookData = [
            'id' => $book->id,
            'nombre' => $book->nombre,
            'fecha_publicacion' => $book->fecha_publicacion,
            'edicion' => $book->edicion,
            'authors' => $book->authors->map(function ($author) {
                return [
                    'id' => $author->id,
                    'nombre' => $author->nombre,
                    'apellido' => $author->apellido,
                    'nombre_completo' => $author->nombre . ' ' . $author->apellido,
                    'pais' => $author->pais,
                ];
            }),
            'cantidad_autores' => $book->authors->count(),
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at,
        ];

        // Si es una petición AJAX, retornar JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'props' => [
                    'book' => $bookData
                ]
            ]);
        }

        // Si es una petición normal, retornar la vista
        return Inertia::render('Books/Show', [
            'book' => $bookData
        ]);
    }/**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::orderBy('nombre')
            ->get()
            ->map(function ($author) {
                return [
                    'id' => $author->id,
                    'nombre' => $author->nombre,
                    'apellido' => $author->apellido,
                    'nombre_completo' => $author->nombre . ' ' . $author->apellido,
                ];
            });$bookData = [
            'id' => $book->id,
            'nombre' => $book->nombre,
            'fecha_publicacion' => $book->fecha_publicacion?->format('Y-m-d'),
            'edicion' => $book->edicion,
            'author_ids' => $book->authors->pluck('id')->toArray(),
        ];

        return Inertia::render('Books/Edit', [
            'book' => $bookData,
            'authors' => $authors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_publicacion' => 'nullable|date',
            'edicion' => 'nullable|string|max:100',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id'
        ], [
            'authors.required' => 'Debes seleccionar al menos un autor para el libro.',
            'authors.min' => 'Debes seleccionar al menos un autor para el libro.',
        ]);

        $book->update($validated);

        // Sincronizar autores
        $book->authors()->sync($validated['authors'] ?? []);

        return Redirect::route('books.index')
            ->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->authors()->detach();
        $book->delete();

        return Redirect::route('books.index')
            ->with('success', 'Libro eliminado exitosamente.');
    }
}

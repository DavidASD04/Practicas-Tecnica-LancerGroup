<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        // Obtener autores
        $gabriel = Author::where('nombre', 'Gabriel García')->first();
        $isabel = Author::where('nombre', 'Isabel')->first();
        $mario = Author::where('nombre', 'Mario')->first();
        $julio = Author::where('nombre', 'Julio')->first();
        $octavio = Author::where('nombre', 'Octavio')->first();        $books = [
            [
                'nombre' => 'Cien años de soledad',
                'fecha_publicacion' => '1967-05-30',
                'edicion' => 'Primera edición'
            ],
            [
                'nombre' => 'El amor en los tiempos del cólera',
                'fecha_publicacion' => '1985-09-05',
                'edicion' => 'Primera edición'
            ],            [
                'nombre' => 'La casa de los espíritus',
                'fecha_publicacion' => '1982-01-01',
                'edicion' => 'Primera edición'
            ],
            [
                'nombre' => 'Paula',
                'fecha_publicacion' => '1994-01-01',
                'edicion' => 'Primera edición'
            ],
            [
                'nombre' => 'Conversación en La Catedral',
                'fecha_publicacion' => '1969-01-01',
                'edicion' => 'Primera edición'
            ],            [
                'nombre' => 'Rayuela',
                'fecha_publicacion' => '1963-06-28',
                'edicion' => 'Primera edición'
            ],
            [
                'nombre' => 'El laberinto de la soledad',
                'fecha_publicacion' => '1950-01-01',
                'edicion' => 'Primera edición'
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }        // Crear relaciones many-to-many entre autores y libros
        if ($gabriel && $isabel && $mario) {
            // Algunos libros pueden tener múltiples autores (para demostrar la relación many-to-many)
            $cienAnos = Book::where('nombre', 'Cien años de soledad')->first();
            if ($cienAnos) {
                $cienAnos->authors()->attach($gabriel->id, ['rol' => 'Autor principal']);
            }

            $casaEspiritus = Book::where('nombre', 'La casa de los espíritus')->first();
            if ($casaEspiritus) {
                $casaEspiritus->authors()->attach($isabel->id, ['rol' => 'Autora']);
            }
        }
    }
}
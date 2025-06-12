<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear autores de prueba
        $autores = [
            ['nombre' => 'Gabriel', 'apellido' => 'García Márquez', 'pais' => 'Colombia'],
            ['nombre' => 'Isabel', 'apellido' => 'Allende', 'pais' => 'Chile'],
            ['nombre' => 'Mario', 'apellido' => 'Vargas Llosa', 'pais' => 'Perú'],
            ['nombre' => 'Octavio', 'apellido' => 'Paz', 'pais' => 'México'],
            ['nombre' => 'Jorge Luis', 'apellido' => 'Borges', 'pais' => 'Argentina'],
            ['nombre' => 'Pablo', 'apellido' => 'Neruda', 'pais' => 'Chile'],
            ['nombre' => 'Julio', 'apellido' => 'Cortázar', 'pais' => 'Argentina'],
            ['nombre' => 'Carlos', 'apellido' => 'Fuentes', 'pais' => 'México'],
        ];

        foreach ($autores as $autorData) {
            Author::create($autorData);
        }

        // Crear libros de prueba
        $libros = [
            [
                'nombre' => 'Cien años de soledad',
                'fecha_publicacion' => '1967-06-05',
                'edicion' => 'Primera edición',
                'autores' => [1] // Gabriel García Márquez
            ],
            [
                'nombre' => 'La casa de los espíritus',
                'fecha_publicacion' => '1982-10-01',
                'edicion' => 'Primera edición',
                'autores' => [2] // Isabel Allende
            ],
            [
                'nombre' => 'La ciudad y los perros',
                'fecha_publicacion' => '1963-02-01',
                'edicion' => 'Primera edición',
                'autores' => [3] // Mario Vargas Llosa
            ],
            [
                'nombre' => 'El laberinto de la soledad',
                'fecha_publicacion' => '1950-01-01',
                'edicion' => 'Primera edición',
                'autores' => [4] // Octavio Paz
            ],
            [
                'nombre' => 'Ficciones',
                'fecha_publicacion' => '1944-01-01',
                'edicion' => 'Primera edición',
                'autores' => [5] // Jorge Luis Borges
            ],
            [
                'nombre' => 'Veinte poemas de amor y una canción desesperada',
                'fecha_publicacion' => '1924-01-01',
                'edicion' => 'Primera edición',
                'autores' => [6] // Pablo Neruda
            ],
            [
                'nombre' => 'Rayuela',
                'fecha_publicacion' => '1963-06-28',
                'edicion' => 'Primera edición',
                'autores' => [7] // Julio Cortázar
            ],
            [
                'nombre' => 'La muerte de Artemio Cruz',
                'fecha_publicacion' => '1962-01-01',
                'edicion' => 'Primera edición',
                'autores' => [8] // Carlos Fuentes
            ],
            [
                'nombre' => 'Antología colaborativa',
                'fecha_publicacion' => '2020-01-01',
                'edicion' => 'Edición especial',
                'autores' => [1, 2, 3] // Múltiples autores
            ],
        ];

        foreach ($libros as $libroData) {
            $autores = $libroData['autores'];
            unset($libroData['autores']);
            
            $libro = Book::create($libroData);
            $libro->authors()->attach($autores);
        }

        $this->command->info('Base de datos poblada exitosamente!');
        $this->command->info('- ' . Author::count() . ' autores creados');
        $this->command->info('- ' . Book::count() . ' libros creados');
    }
}

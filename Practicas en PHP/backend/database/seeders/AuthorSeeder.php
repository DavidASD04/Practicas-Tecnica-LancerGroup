<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        $authors = [
            [
                'nombre' => 'Gabriel García',
                'apellido' => 'Márquez',
                'pais' => 'Colombia'
            ],
            [
                'nombre' => 'Isabel',
                'apellido' => 'Allende',
                'pais' => 'Chile'
            ],
            [
                'nombre' => 'Mario',
                'apellido' => 'Vargas Llosa',
                'pais' => 'Perú'
            ],
            [
                'nombre' => 'Julio',
                'apellido' => 'Cortázar',
                'pais' => 'Argentina'
            ],
            [
                'nombre' => 'Octavio',
                'apellido' => 'Paz',
                'pais' => 'México'
            ]
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
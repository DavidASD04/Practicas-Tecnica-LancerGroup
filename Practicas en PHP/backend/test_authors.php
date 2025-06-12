<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Author;

echo "Testing Author data:\n\n";

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

foreach ($authors as $author) {
    echo "ID: " . $author['id'] . "\n";
    echo "Nombre: " . $author['nombre'] . "\n";
    echo "Apellido: " . $author['apellido'] . "\n";
    echo "Nombre Completo: " . $author['nombre_completo'] . "\n";
    echo "---\n";
}

echo "Total authors: " . $authors->count() . "\n";

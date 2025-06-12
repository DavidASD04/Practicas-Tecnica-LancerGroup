<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Author;

echo "Probando creación de autor...\n\n";

try {
    $author = Author::create([
        'nombre' => 'Carlos',
        'apellido' => 'Fuentes',
        'pais' => 'México'
    ]);
    
    echo "✅ Autor creado exitosamente:\n";
    echo "ID: " . $author->id . "\n";
    echo "Nombre: " . $author->nombre . "\n";
    echo "Apellido: " . $author->apellido . "\n";
    echo "País: " . $author->pais . "\n";
    echo "Nombre completo: " . $author->nombre_completo . "\n";
    echo "Cantidad de libros: " . $author->cantidad_libros . "\n";
    
} catch (Exception $e) {
    echo "❌ Error al crear autor: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\nTotal de autores en la base de datos: " . Author::count() . "\n";

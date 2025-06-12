<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_publicacion');
            $table->string('edicion');
            $table->string('isbn')->nullable()->unique();
            $table->integer('paginas')->nullable();
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index('nombre');
            $table->index('fecha_publicacion');
            $table->index('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

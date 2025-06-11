<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_publicacion');
            $table->string('edicion');
            $table->timestamps();
            
            $table->index('nombre');
            $table->index('fecha_publicacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

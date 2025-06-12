<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido',
        'pais',
        'fecha_registro'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    protected $appends = ['nombre_completo', 'cantidad_libros'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getCantidadLibrosAttribute(): int
    {
        return $this->books()->count();
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['nombre_completo'] = $this->nombre_completo;
        $array['cantidad_libros'] = $this->cantidad_libros;
        return $array;
    }
}

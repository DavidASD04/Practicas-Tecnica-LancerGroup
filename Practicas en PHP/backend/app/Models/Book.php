<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_publicacion',
        'edicion',
        'descripcion',
        'isbn',
        'paginas'
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withTrashed();
    }

    public function activeAuthors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}

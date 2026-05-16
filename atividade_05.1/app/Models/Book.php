<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

protected $fillable = [
    'title',
    'author_id',
    'category_id',
    'publisher_id',
    'published_year',
    'pages'
];
    /**
     * Relacionamento N para N com Usuários através da tabela borrowings
     */
    public function users(): BelongsToMany
    {
    return $this->belongsToMany(User::class, 'borrowings')
        ->withPivot('id', 'borrowed_at', 'returned_at')
        ->withTimestamps();
}

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
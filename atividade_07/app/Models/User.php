<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Constantes para os papéis
    public const ROLE_ADMIN = 'admin';
    public const ROLE_BIBLIOTECARIO = 'bibliotecario';
    public const ROLE_CLIENTE = 'cliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento Muitos-para-Muitos com Livros (via borrowings)
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'borrowings')
                    ->withPivot('id', 'borrowed_at', 'returned_at')
                    ->withTimestamps();
    }

    /**
     * Verifica se o usuário é admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Verifica se o usuário é bibliotecário
     */
    public function isBibliotecario(): bool
    {
        return $this->role === self::ROLE_BIBLIOTECARIO;
    }

    /**
     * Verifica se o usuário é cliente
     */
    public function isCliente(): bool
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    /**
     * Verifica se o usuário tem permissão para gerenciar livros (admin ou bibliotecario)
     */
    public function canManageBooks(): bool
    {
        return $this->isAdmin() || $this->isBibliotecario();
    }

    /**
     * Verifica se o usuário pode gerenciar usuários (apenas admin)
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }
}
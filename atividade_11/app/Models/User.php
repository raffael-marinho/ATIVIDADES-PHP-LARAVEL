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

    // Constante para dias de empréstimo
    public const DIAS_EMPRESTIMO = 15;
    public const MULTA_POR_DIA = 0.50;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'debit', // Adicionar débito
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'borrowings')
                    ->withPivot('id', 'borrowed_at', 'returned_at')
                    ->withTimestamps();
    }

    // ==================== MÉTODOS DE PAPEL ====================

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBibliotecario(): bool
    {
        return $this->role === self::ROLE_BIBLIOTECARIO;
    }

    public function isCliente(): bool
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    public function canManageBooks(): bool
    {
        return $this->isAdmin() || $this->isBibliotecario();
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    // ==================== MÉTODOS DE DÉBITO ====================

    public function hasDebit(): bool
    {
        return $this->debit > 0;
    }

    public function getDebitFormatted(): string
    {
        return 'R$ ' . number_format($this->debit, 2, ',', '.');
    }

    public function addDebit(float $value): void
    {
        $this->debit += $value;
        $this->save();
    }

    public function clearDebit(): void
    {
        $this->debit = 0;
        $this->save();
    }

    public function calculateFine($borrowedAt, $returnedAt): float
    {
        $borrowed = new \DateTime($borrowedAt);
        $returned = new \DateTime($returnedAt);
        $diff = $borrowed->diff($returned);

        $diasEmprestimo = $diff->days;

        // Se passou do prazo (15 dias)
        if ($diasEmprestimo > self::DIAS_EMPRESTIMO) {
            $diasAtraso = $diasEmprestimo - self::DIAS_EMPRESTIMO;
            return $diasAtraso * self::MULTA_POR_DIA;
        }

        return 0;
    }
}
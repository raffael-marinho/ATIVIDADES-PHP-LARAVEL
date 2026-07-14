<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos podem visualizar
    }

    public function view(User $user, Book $book): bool
    {
        return true; // Todos podem visualizar
    }

    public function create(User $user): bool
    {
        return $user->canManageBooks(); // Admin ou bibliotecario
    }

    public function update(User $user, Book $book): bool
    {
        return $user->canManageBooks(); // Admin ou bibliotecario
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->canManageBooks(); // Admin ou bibliotecario
    }
}
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;

class AuthorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Author $author): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->canManageBooks();
    }

    public function update(User $user, Author $author): bool
    {
        return $user->canManageBooks();
    }

    public function delete(User $user, Author $author): bool
    {
        return $user->canManageBooks();
    }
}
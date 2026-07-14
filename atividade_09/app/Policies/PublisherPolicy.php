<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Publisher;

class PublisherPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Publisher $publisher): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->canManageBooks();
    }

    public function update(User $user, Publisher $publisher): bool
    {
        return $user->canManageBooks();
    }

    public function delete(User $user, Publisher $publisher): bool
    {
        return $user->canManageBooks();
    }
}
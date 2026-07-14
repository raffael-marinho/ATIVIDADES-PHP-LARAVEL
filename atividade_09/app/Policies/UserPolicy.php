<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageUsers() || $user->isBibliotecario();
    }

    public function view(User $user, User $model): bool
    {
        return $user->canManageUsers() || $user->isBibliotecario() || $user->id === $model->id;
    }

    public function update(User $user, User $model): bool
    {
        // Apenas admin pode editar outros usuários
        // Bibliotecario pode editar apenas clientes (mas não papel)
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isBibliotecario() && $model->isCliente()) {
            return true;
        }

        // Usuário pode editar a si mesmo
        return $user->id === $model->id;
    }

    public function updateRole(User $user, User $model): bool
    {
        // Apenas admin pode editar papéis
        return $user->isAdmin();
    }
}
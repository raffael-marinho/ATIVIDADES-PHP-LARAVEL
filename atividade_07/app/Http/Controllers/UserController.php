<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Verifica se o usuário está logado e é admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            $request->validate([
                'role' => 'required|in:admin,bibliotecario,cliente',
            ]);
            $user->role = $request->role;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'Usuário atualizado com sucesso.');
    }

    // Não implementar create, store, destroy conforme especificado
}
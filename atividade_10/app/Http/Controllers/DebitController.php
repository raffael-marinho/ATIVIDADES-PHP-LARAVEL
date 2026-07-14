<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebitController extends Controller
{
    // Lista usuários com débito
    public function index()
    {
        $users = User::where('debit', '>', 0)->paginate(10);
        return view('debits.index', compact('users'));
    }

    // Mostra detalhes do débito de um usuário
    public function show(User $user)
    {
        return view('debits.show', compact('user'));
    }

    // Zera o débito de um usuário (pagamento)
    public function pay(Request $request, User $user)
    {
        if (!$user->hasDebit()) {
            return redirect()->route('debits.index')
                             ->with('error', 'Este usuário não possui débito pendente.');
        }

        $valorPago = $user->getDebitFormatted();
        $user->clearDebit();

        return redirect()->route('debits.index')
                         ->with('success', 'Débito de ' . $valorPago . ' pago com sucesso para o usuário ' . $user->name . '.');
    }
}
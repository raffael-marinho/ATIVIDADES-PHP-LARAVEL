<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    // Constante para o limite máximo de livros por usuário
    const MAX_LIVROS_EMPRESTADOS = 5;

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Verifica se o livro já possui um empréstimo em aberto (sem data de devolução)
        $emprestimoEmAberto = Borrowing::where('book_id', $book->id)
                                       ->whereNull('returned_at')
                                       ->exists();

        if ($emprestimoEmAberto) {
            return back()->with('error', 'Este livro já possui um empréstimo em aberto. Aguarde a devolução para realizar um novo empréstimo.');
        }

        // Conta quantos livros o usuário já tem emprestados (sem devolução)
        $emprestimosAtivos = Borrowing::where('user_id', $request->user_id)
                                      ->whereNull('returned_at')
                                      ->count();

        // Verifica se o usuário já atingiu o limite máximo de empréstimos
        if ($emprestimosAtivos >= self::MAX_LIVROS_EMPRESTADOS) {
            return back()->with('error', 'Este usuário já atingiu o limite máximo de ' . self::MAX_LIVROS_EMPRESTADOS . ' livros emprestados simultaneamente.');
        }

        // Cria o empréstimo
        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Empréstimo registrado com sucesso. O usuário possui ' . ($emprestimosAtivos + 1) . ' de ' . self::MAX_LIVROS_EMPRESTADOS . ' empréstimos ativos.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'returned_at' => Carbon::now(),
        ]);

        // Conta quantos empréstimos ativos o usuário ainda tem
        $emprestimosAtivos = Borrowing::where('user_id', $borrowing->user_id)
                                      ->whereNull('returned_at')
                                      ->count();

        return back()->with('success', 'Devolução registrada com sucesso. O usuário possui ' . $emprestimosAtivos . ' empréstimos ativos.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()
            ->withPivot('id', 'borrowed_at', 'returned_at')
            ->get();

        // Conta empréstimos ativos para exibir no histórico
        $ativos = Borrowing::where('user_id', $user->id)
                           ->whereNull('returned_at')
                           ->count();

        return view('users.borrowings', compact('user', 'borrowings', 'ativos'));
    }
}
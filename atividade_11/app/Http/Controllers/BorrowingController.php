<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public const MAX_LIVROS_EMPRESTADOS = 5;

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        // Verifica se o usuário tem débito pendente
        if ($user->hasDebit()) {
            return back()->with('error', 'Este usuário possui débito pendente de ' . $user->getDebitFormatted() . '. Regularize o débito para realizar um novo empréstimo.');
        }

        // Verifica se o livro já possui um empréstimo em aberto
        $emprestimoEmAberto = Borrowing::where('book_id', $book->id)
                                       ->whereNull('returned_at')
                                       ->exists();

        if ($emprestimoEmAberto) {
            return back()->with('error', 'Este livro já possui um empréstimo em aberto. Aguarde a devolução para realizar um novo empréstimo.');
        }

        // Verifica se o usuário já atingiu o limite máximo de empréstimos
        $emprestimosAtivos = Borrowing::where('user_id', $user->id)
                                      ->whereNull('returned_at')
                                      ->count();

        if ($emprestimosAtivos >= self::MAX_LIVROS_EMPRESTADOS) {
            return back()->with('error', 'Este usuário já atingiu o limite máximo de ' . self::MAX_LIVROS_EMPRESTADOS . ' livros emprestados simultaneamente.');
        }

        // Cria o empréstimo
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Empréstimo registrado com sucesso! Prazo de devolução: 15 dias.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $user = User::find($borrowing->user_id);
        $returnedAt = Carbon::now();
        $borrowedAt = Carbon::parse($borrowing->borrowed_at);

        // Calcula o número de dias de empréstimo
        $diasEmprestimo = $borrowedAt->diffInDays($returnedAt);

        // Calcula a multa se houver atraso (mais de 15 dias)
        $multa = 0;
        $diasAtraso = 0;

        if ($diasEmprestimo > User::DIAS_EMPRESTIMO) {
            $diasAtraso = $diasEmprestimo - User::DIAS_EMPRESTIMO;
            $multa = $diasAtraso * User::MULTA_POR_DIA;
            $user->addDebit($multa);
        }

        // Atualiza a data de devolução
        $borrowing->update([
            'returned_at' => $returnedAt,
        ]);

        // Mensagem de sucesso
        $mensagem = 'Devolução registrada com sucesso.';

        if ($multa > 0) {
            $mensagem .= ' O livro foi devolvido com ' . $diasAtraso . ' dias de atraso. Multa gerada: R$ ' . number_format($multa, 2, ',', '.') . '. Débito total do usuário: ' . $user->getDebitFormatted() . '.';
        } else {
            $mensagem .= ' Devolução dentro do prazo de 15 dias.';
        }

        return back()->with('success', $mensagem);
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()
            ->withPivot('id', 'borrowed_at', 'returned_at')
            ->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }
}
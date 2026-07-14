<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
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

        // Cria o empréstimo
        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'returned_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()
            ->withPivot('id', 'borrowed_at', 'returned_at')
            ->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }
}
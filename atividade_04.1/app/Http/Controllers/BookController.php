<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Listagem com Eager Loading para evitar o N+1 
    public function index()
    {
        $books = Book::with('author')->paginate(20);
        return view('books.index', compact('books'));
    }

    // Versão 1: Create com Input de ID [cite: 185]
    public function createWithId()
    {
        return view('books.create-id');
    }

    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Versão 2: Create com Select (Mais intuitivo) [cite: 202]
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    public function storeWithSelect(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Visualização de detalhes [cite: 445]
    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);
        return view('books.show', compact('book'));
    }
}
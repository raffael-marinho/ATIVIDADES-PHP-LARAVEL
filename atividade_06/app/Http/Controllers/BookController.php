<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    /*
    |--------------------------------------------------------------------------
    | NOVOS MÉTODOS DA ATIVIDADE 6
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'pages' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('cover_image')) {

            $imagePath = $request->file('cover_image')
                                 ->store('covers', 'public');
        }

        Book::create([
            'title' => $request->title,
            'publisher_id' => $request->publisher_id,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'published_year' => $request->published_year,
            'pages' => $request->pages,
            'cover_image' => $imagePath,
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro criado com sucesso.');
    }

    // Versão 1: Create com Input de ID
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

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro criado com sucesso.');
    }

    // Versão 2: Create com Select
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view(
            'books.create-select',
            compact('publishers', 'authors', 'categories')
        );
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

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro criado com sucesso.');
    }

    // Visualização de detalhes
    public function show(Book $book)
    {
        $book->load([
            'author',
            'publisher',
            'category',
            'users'
        ]);

        $users = User::all();

        return view('books.show', compact('book', 'users'));
    }
}
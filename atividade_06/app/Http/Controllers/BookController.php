<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Listagem com Eager Loading para evitar o N+1
    public function index()
    {
        $books = Book::with('author')->paginate(20);
        return view('books.index', compact('books'));
    }

    // ==================== CRUD PADRÃO (com upload de capa) ====================

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'publisher_id'   => 'required|exists:publishers,id',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'pages'          => 'required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('books.index')
                         ->with('success', 'Livro criado com sucesso.');
    }

    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category', 'users']);
        $users = User::all();
        return view('books.show', compact('book', 'users'));
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'publisher_id'   => 'required|exists:publishers,id',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'pages'          => 'required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            // Deletar imagem antiga
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('books.index')
                         ->with('success', 'Livro atualizado com sucesso.');
    }

    public function destroy(Book $book)
    {
        // Deletar imagem de capa
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')
                         ->with('success', 'Livro excluído com sucesso.');
    }

    // ==================== VERSÃO 1: CREATE COM INPUT DE ID ====================

    public function createWithId()
    {
        return view('books.create-id');
    }

    public function storeWithId(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'publisher_id'   => 'required|exists:publishers,id',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'pages'          => 'required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('books.index')
                         ->with('success', 'Livro criado com sucesso (via ID).');
    }

    // ==================== VERSÃO 2: CREATE COM SELECT ====================

    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors    = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    public function storeWithSelect(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'publisher_id'   => 'required|exists:publishers,id',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'pages'          => 'required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('books.index')
                         ->with('success', 'Livro criado com sucesso (via Select).');
    }
}
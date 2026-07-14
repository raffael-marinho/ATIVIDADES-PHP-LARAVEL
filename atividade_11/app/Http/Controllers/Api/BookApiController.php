<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookApiController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index()
    {
        $books = Book::with(['author', 'category', 'publisher'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $books
        ], 200);
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'pages' => 'required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        $book = Book::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Livro criado com sucesso.',
            'data' => $book->load(['author', 'category', 'publisher'])
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        $book = Book::with(['author', 'category', 'publisher', 'users'])->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Livro não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $book
        ], 200);
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Livro não encontrado.'
            ], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'publisher_id' => 'sometimes|required|exists:publishers,id',
            'pages' => 'sometimes|required|integer|min:1',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            // Deletar imagem antiga
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Livro atualizado com sucesso.',
            'data' => $book->fresh()->load(['author', 'category', 'publisher'])
        ], 200);
    }

    /**
     * Remove the specified book.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Livro não encontrado.'
            ], 404);
        }

        // Deletar imagem de capa
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Livro excluído com sucesso.'
        ], 200);
    }
}
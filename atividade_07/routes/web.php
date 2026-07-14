<?php

use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Atividade 4.2 - CRUD de Categorias
|--------------------------------------------------------------------------
*/
Route::resource('categories', CategoryController::class)->middleware('auth');

/*
|--------------------------------------------------------------------------
| Atividade 4.3 - CRUD de Livros
|--------------------------------------------------------------------------
*/
// Rotas específicas de criação (devem vir antes do resource)
Route::get('/books/create-id-number', [BookController::class, 'createWithId'])
    ->name('books.create.id')
    ->middleware('auth', 'can:create,App\Models\Book');

Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])
    ->name('books.store.id')
    ->middleware('auth', 'can:create,App\Models\Book');

Route::get('/books/create-select', [BookController::class, 'createWithSelect'])
    ->name('books.create.select')
    ->middleware('auth', 'can:create,App\Models\Book');

Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])
    ->name('books.store.select')
    ->middleware('auth', 'can:create,App\Models\Book');

// Rota Resource para as demais operações (index, show, edit, update, destroy)
Route::get('/books/create', [BookController::class, 'create'])
    ->name('books.create')
    ->middleware('auth', 'can:create,App\Models\Book');

Route::post('/books', [BookController::class, 'store'])
    ->name('books.store')
    ->middleware('auth', 'can:create,App\Models\Book');

Route::resource('books', BookController::class)
    ->except(['create', 'store'])
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Atividade 5.2 - Sistema de Empréstimos
|--------------------------------------------------------------------------
*/
Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])
    ->name('books.borrow')
    ->middleware('auth');

Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])
    ->name('users.borrowings')
    ->middleware('auth');

Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Atividade 4.2/5.1 - CRUD de Autores, Editoras e Usuários
|--------------------------------------------------------------------------
*/
Route::resource('authors', AuthorController::class)->middleware('auth');
Route::resource('publishers', PublisherController::class)->middleware('auth');
Route::resource('users', UserController::class)
    ->except(['create', 'store', 'destroy'])
    ->middleware('auth');
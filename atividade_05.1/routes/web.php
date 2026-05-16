<?php
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

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
Route::resource('categories', CategoryController::class);

/*
|--------------------------------------------------------------------------
| Atividade 4.3 - CRUD de Livros
|--------------------------------------------------------------------------
*/
// Rotas específicas de criação (devem vir antes do resource)
Route::get('/books/create-id-number', [BookController::class, 'createWithId'])->name('books.create.id');
Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])->name('books.store.id');

Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');

// Rota Resource para as demais operações (index, show, edit, update, destroy)
Route::resource('books', BookController::class)->except(['create', 'store']);

Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])
    ->name('books.borrow');

Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])
    ->name('users.borrowings');

Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return');
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $book->title }}</h1>

    {{-- Mensagens de sucesso/erro --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Status do Livro --}}
    @php
        $emprestimoEmAberto = App\Models\Borrowing::where('book_id', $book->id)
                                ->whereNull('returned_at')
                                ->exists();
    @endphp

    @if($emprestimoEmAberto)
        <div class="alert alert-warning mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i> 
            <strong>Este livro está emprestado no momento.</strong> Aguarde a devolução para realizar um novo empréstimo.
        </div>
    @else
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle-fill"></i> 
            <strong>Este livro está disponível para empréstimo!</strong>
        </div>
    @endif

    {{-- IMAGEM DA CAPA COM FALLBACK --}}
    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.png') }}" 
         alt="Capa do Livro" 
         width="200" 
         class="img-thumbnail mb-4">

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Autor:</strong> {{ $book->author->name }}</p>
            <p><strong>Categoria:</strong> {{ $book->category->name }}</p>
            <p><strong>Editora:</strong> {{ $book->publisher->name }}</p>
            <p><strong>Ano:</strong> {{ $book->published_year }}</p>
            <p><strong>Páginas:</strong> {{ $book->pages }}</p>
        </div>
    </div>

    <!-- Formulário para Empréstimos -->
    <div class="card mb-4">
        <div class="card-header">Registrar Empréstimo</div>
        <div class="card-body">
            @if($emprestimoEmAberto)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i> 
                    Este livro não está disponível para empréstimo no momento.
                </div>
            @else
                <form action="{{ route('books.borrow', $book) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Usuário</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Selecione um usuário</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Histórico -->
    <div class="card">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            @if($book->users->isEmpty())
                <p>Nenhum empréstimo registrado.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Data Empréstimo</th>
                            <th>Data Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->pivot->borrowed_at }}</td>
                                <td>{{ $user->pivot->returned_at ?? 'Em Aberto' }}</td>
                                <td>
                                    @if(is_null($user->pivot->returned_at))
                                        <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">Devolver</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- BOTÃO VOLTAR --}}
    <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection
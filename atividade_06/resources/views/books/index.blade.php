@extends('layouts.app')
<a href="{{ url('/') }}" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Voltar para o Início
</a>
@section('content')
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('books.create') }}" class="btn btn-success">
            <i class="bi bi-plus"></i> Adicionar Livro (padrão)
        </a>
        <a href="{{ route('books.create.id') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Adicionar Livro (com ID)
        </a>
        <a href="{{ route('books.create.select') }}" class="btn btn-info">
            <i class="bi bi-plus"></i> Adicionar Livro (com Select)
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                                <i class="bi bi-trash"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Nenhum livro encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $books->links() }}
</div>
@endsection
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar para o Início
    </a>
    <!-- resto do conteúdo -->
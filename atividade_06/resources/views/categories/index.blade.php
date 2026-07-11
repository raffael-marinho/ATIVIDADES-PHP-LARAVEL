@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar para o Início
    </a>

    <h1 class="my-4">Lista de Categorias</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> Adicionar Categoria
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhuma categoria encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
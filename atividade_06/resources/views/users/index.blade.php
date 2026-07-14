@extends('layouts.app')
<<<<<<< HEAD
<a href="{{ url('/') }}" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Voltar para o Início
</a>
@section('content')
<div class="container">
    <h1 class="my-4">Lista de Usuários</h1>
=======

@section('content')
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar para o Início
    </a>

    <h1 class="my-4">Lista de Usuários</h1>

>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Nenhum usuário encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links() }}
</div>
<<<<<<< HEAD
@endsection
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar para o Início
    </a>
    <!-- resto do conteúdo -->
=======
@endsection
>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11

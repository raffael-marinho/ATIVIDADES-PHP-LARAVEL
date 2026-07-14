@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar para o Início
    </a>

    <h1 class="my-4">Lista de Usuários</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Papel</th>
                <th>Empréstimos Ativos</th>
                <th>Débito</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    $emprestimosAtivos = App\Models\Borrowing::where('user_id', $user->id)
                                            ->whereNull('returned_at')
                                            ->count();
                @endphp
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'bibliotecario' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $emprestimosAtivos >= 5 ? 'danger' : ($emprestimosAtivos >= 4 ? 'warning' : 'success') }}">
                            {{ $emprestimosAtivos }}/5
                        </span>
                    </td>
                    <td>
                        @if($user->hasDebit())
                            <span class="badge bg-danger">
                                {{ $user->getDebitFormatted() }}
                            </span>
                        @else
                            <span class="badge bg-success">✅</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        @if($user->hasDebit() && auth()->user()->canManageBooks())
                            <a href="{{ route('debits.show', $user) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-cash"></i> Pagar
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Nenhum usuário encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
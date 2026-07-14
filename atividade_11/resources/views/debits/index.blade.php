@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">💰 Usuários com Débito Pendente</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($users->isEmpty())
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i> Nenhum usuário com débito pendente!
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Débito</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-danger">
                                {{ $user->getDebitFormatted() }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('debits.show', $user) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <form action="{{ route('debits.pay', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm" onclick="return confirm('Confirmar pagamento do débito de {{ $user->getDebitFormatted() }} para {{ $user->name }}?')">
                                    <i class="bi bi-cash"></i> Pagar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    @endif

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection
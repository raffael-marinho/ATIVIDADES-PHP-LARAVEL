@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Débito</h1>

    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Usuário: {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Débito Total:</strong> 
                <span class="badge bg-danger" style="font-size: 1.2rem;">
                    {{ $user->getDebitFormatted() }}
                </span>
            </p>
            <hr>
            <h5>Histórico de Empréstimos com Atraso</h5>
            @php
                $borrowings = App\Models\Borrowing::where('user_id', $user->id)
                                ->whereNotNull('returned_at')
                                ->get();
                $debitosGerados = 0;
            @endphp

            @if($borrowings->isEmpty())
                <p class="text-muted">Nenhum empréstimo com atraso registrado.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Data Empréstimo</th>
                            <th>Data Devolução</th>
                            <th>Dias de Atraso</th>
                            <th>Multa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                            @php
                                $book = App\Models\Book::find($borrowing->book_id);
                                $borrowedAt = \Carbon\Carbon::parse($borrowing->borrowed_at);
                                $returnedAt = \Carbon\Carbon::parse($borrowing->returned_at);
                                $diasEmprestimo = $borrowedAt->diffInDays($returnedAt);
                                $diasAtraso = max(0, $diasEmprestimo - App\Models\User::DIAS_EMPRESTIMO);
                                $multa = $diasAtraso * App\Models\User::MULTA_POR_DIA;
                                $debitosGerados += $multa;
                            @endphp
                            @if($multa > 0)
                                <tr>
                                    <td>{{ $book->title ?? 'Livro removido' }}</td>
                                    <td>{{ $borrowing->borrowed_at }}</td>
                                    <td>{{ $borrowing->returned_at }}</td>
                                    <td><span class="badge bg-warning">{{ $diasAtraso }} dias</span></td>
                                    <td><span class="badge bg-danger">R$ {{ number_format($multa, 2, ',', '.') }}</span></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="alert alert-info">
                <strong>Total de multas geradas:</strong> 
                <span class="badge bg-danger" style="font-size: 1.1rem;">
                    R$ {{ number_format($debitosGerados, 2, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <form action="{{ route('debits.pay', $user) }}" method="POST" style="display:inline;">
        @csrf
        <button class="btn btn-success" onclick="return confirm('Confirmar pagamento do débito de {{ $user->getDebitFormatted() }} para {{ $user->name }}?')">
            <i class="bi bi-cash"></i> Registrar Pagamento
        </button>
    </form>
    <a href="{{ route('debits.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection
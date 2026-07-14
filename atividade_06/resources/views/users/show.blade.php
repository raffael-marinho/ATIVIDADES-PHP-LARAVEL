@extends('layouts.app')
<<<<<<< HEAD
<a href="{{ route('entidade.index') }}" class="btn btn-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Voltar
</a>
@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Usuário</h1>
=======

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Usuário</h1>

>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    <div class="card">
        <div class="card-header">{{ $user->name }}</div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>
<<<<<<< HEAD
=======

>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection
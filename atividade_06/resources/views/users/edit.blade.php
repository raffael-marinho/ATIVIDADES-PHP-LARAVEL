@extends('layouts.app')
<<<<<<< HEAD
<a href="{{ route('entidade.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Voltar
</a>
@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>
=======

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
<<<<<<< HEAD
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
=======
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
<<<<<<< HEAD
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
=======
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    </form>
</div>
@endsection
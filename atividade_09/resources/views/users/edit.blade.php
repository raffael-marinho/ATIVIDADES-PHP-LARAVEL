@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Campo de papel (apenas admin pode ver e alterar) --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="mb-3">
            <label for="role" class="form-label">Papel</label>
            <select class="form-select @error('role') is-invalid @enderror" 
                    id="role" name="role">
                <option value="cliente" {{ old('role', $user->role) == 'cliente' ? 'selected' : '' }}>
                    Cliente
                </option>
                <option value="bibliotecario" {{ old('role', $user->role) == 'bibliotecario' ? 'selected' : '' }}>
                    Bibliotecário
                </option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        @else
        <div class="mb-3">
            <label class="form-label">Papel</label>
            <p class="form-control-static">
                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'bibliotecario' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($user->role) }}
                </span>
            </p>
        </div>
        @endif

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
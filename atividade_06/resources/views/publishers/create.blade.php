@extends('layouts.app')
<<<<<<< HEAD
<a href="{{ route('entidade.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Voltar
</a>
=======

>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
@section('content')
<div class="container">
    <h1 class="my-4">Adicionar Editora</h1>

    <form action="{{ route('publishers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Endereço</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
<<<<<<< HEAD
        <a href="{{ route('publishers.index') }}" class="btn btn-secondary">Cancelar</a>
=======
        <a href="{{ route('publishers.index') }}" class="btn btn-secondary">Voltar</a>
>>>>>>> 99fdf1e0a8812d04f8734f6fc5c9b0a03c1a4b11
    </form>
</div>
@endsection
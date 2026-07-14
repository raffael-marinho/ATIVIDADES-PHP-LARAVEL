@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Cadastrar Livro</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ano de Publicação</label>
                    <input type="number" name="published_year" class="form-control @error('published_year') is-invalid @enderror" value="{{ old('published_year') }}">
                    @error('published_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Páginas</label>
                    <input type="number" name="pages" class="form-control @error('pages') is-invalid @enderror" value="{{ old('pages') }}" required>
                    @error('pages') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Autor ID</label>
                    <input type="number" name="author_id" class="form-control @error('author_id') is-invalid @enderror" value="{{ old('author_id') }}" required>
                    @error('author_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoria ID</label>
                    <input type="number" name="category_id" class="form-control @error('category_id') is-invalid @enderror" value="{{ old('category_id') }}" required>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Editora ID</label>
                    <input type="number" name="publisher_id" class="form-control @error('publisher_id') is-invalid @enderror" value="{{ old('publisher_id') }}" required>
                    @error('publisher_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagem da Capa</label>
                    <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                    @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Salvar Livro</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</div>
@endsection
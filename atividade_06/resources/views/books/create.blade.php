@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="mb-4">
        Cadastrar Livro
    </h1>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('books.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Título
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Ano de Publicação
                    </label>

                    <input type="number"
                           name="published_year"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Páginas
                    </label>

                    <input type="number"
                           name="pages"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Autor ID
                    </label>

                    <input type="number"
                           name="author_id"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Categoria ID
                    </label>

                    <input type="number"
                           name="category_id"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Editora ID
                    </label>

                    <input type="number"
                           name="publisher_id"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Imagem da Capa
                    </label>

                    <input type="file"
                           name="cover_image"
                           class="form-control">

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Salvar Livro

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
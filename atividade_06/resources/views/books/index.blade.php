@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="my-4">
        Lista de Livros
    </h1>

    <table class="table table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

            @foreach($books as $book)

                <tr>

                    <td>{{ $book->id }}</td>

                    <td>{{ $book->title }}</td>

                    <td>
                        {{ $book->author->name ?? 'Sem Autor' }}
                    </td>

                    <td>

                        <a href="{{ route('books.show', $book) }}"
                           class="btn btn-info btn-sm">

                            Visualizar

                        </a>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>

</div>

@endsection
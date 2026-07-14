@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📊 Dashboard</h4>
                </div>

                <div class="card-body">
                    <h5 class="mb-3">Olá, {{ Auth::user()->name }}! 👋</h5>
                    <p>Bem-vindo ao sistema de gerenciamento de biblioteca. Utilize o menu acima para navegar.</p>

                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h5 class="card-title">📖</h5>
                                    <p class="card-text">Livros</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h5 class="card-title">👤</h5>
                                    <p class="card-text">Autores</p>
                                    <a href="{{ route('authors.index') }}" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h5 class="card-title">🏷️</h5>
                                    <p class="card-text">Categorias</p>
                                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light text-center">
                                <div class="card-body">
                                    <h5 class="card-title">🏢</h5>
                                    <p class="card-text">Editoras</p>
                                    <a href="{{ route('publishers.index') }}" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
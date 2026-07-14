@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <h1 class="display-4 mb-4">📚 Sistema de Gerenciamento de Biblioteca</h1>
            <p class="lead">
                Bem-vindo ao sistema de gerenciamento de biblioteca desenvolvido com Laravel.
                Aqui você pode gerenciar livros, autores, categorias, editoras e empréstimos.
            </p>
            <hr class="my-4">

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">📖 Livros</h5>
                            <p class="card-text">Cadastre, edite, visualize e exclua livros do acervo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">👤 Autores</h5>
                            <p class="card-text">Gerencie os autores com nome, e-mail e data de nascimento.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">🏷️ Categorias</h5>
                            <p class="card-text">Organize os livros por categorias.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">🏢 Editoras</h5>
                            <p class="card-text">Cadastre editoras com endereço.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">🔄 Empréstimos</h5>
                            <p class="card-text">Registre empréstimos e devoluções de livros.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">👥 Usuários</h5>
                            <p class="card-text">Gerencie usuários do sistema.</p>
                        </div>
                    </div>
                </div>
            </div>

            @guest
                <div class="mt-5">
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg me-3">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ url('/register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-person-plus"></i> Registrar
                    </a>
                </div>
                <p class="mt-3 text-muted">Faça login para acessar todas as funcionalidades.</p>
            @else
                <div class="mt-5">
                    <a href="{{ url('/home') }}" class="btn btn-success btn-lg">
                        <i class="bi bi-book"></i> Acessar o Sistema
                    </a>
                </div>
            @endguest
        </div>
    </div>
</div>
@endsection
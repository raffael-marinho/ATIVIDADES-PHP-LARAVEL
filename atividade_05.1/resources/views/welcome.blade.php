@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">Bem-vindo ao Laravel</h1>
            <p class="lead">
                Sistema configurado com Laravel, autenticação e Bootstrap. [cite: 976]
            </p>
            
            @guest
                {{-- Se o usuário não estiver logado, mostra Login e Registro --}}
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a> [cite: 977, 979]
                <a href="{{ route('register') }}" class="btn btn-outline-primary">Registrar</a> [cite: 981, 983]
            @else
                {{-- Se estiver logado, mostra o botão para entrar no sistema --}}
                <a href="{{ route('home') }}" class="btn btn-success">Acessar o sistema</a> [cite: 986, 987]
            @endguest
        </div>
    </div>
</div>
@endsection
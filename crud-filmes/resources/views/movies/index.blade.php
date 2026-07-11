<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Filmes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #333; color: white; }
        .btn { background: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        .alert { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>🎬 Catálogo de Filmes</h1>
    
    <a href="{{ route('movies.create') }}" class="btn">Cadastrar Novo Filme</a>
    <br><br>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Duração (min)</th>
                <th>Categoria</th>
                <th>Orçamento</th>
                <th>Idioma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->description }}</td>
                    <td>{{ $movie->duration }} min</td>
                    <td>{{ $movie->category }}</td>
                    <td>R$ {{ number_format($movie->budget, 2, ',', '.') }}</td>
                    <td>{{ $movie->language }}</td>
                    <td>
                        <a href="{{ route('movies.edit', $movie->id) }}">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum filme cadastrado ainda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Filme</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { background: #28a745; color: white; padding: 10px 15px; border: none; cursor: pointer; font-size: 16px; border-radius: 4px; }
        .btn-back { background: #6c757d; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-top: 10px; border-radius: 4px; }
        .errors { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>🎬 Cadastrar Novo Filme</h1>

    @if ($errors->any())
        <div class="errors">
            <strong>Ops! Verifique os campos abaixo:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('movies.store') }}" method="POST">
        
        @csrf

        <div class="form-group">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="duration">Duração (em minutos):</label>
            <input type="number" id="duration" name="duration" value="{{ old('duration') }}">
        </div>

        <div class="form-group">
            <label for="category">Categoria:</label>
            <input type="text" id="category" name="category" value="{{ old('category') }}">
        </div>

        <div class="form-group">
            <label for="budget">Orçamento (R$):</label>
            <input type="number" step="0.01" id="budget" name="budget" value="{{ old('budget') }}">
        </div>

        <div class="form-group">
            <label for="language">Idioma (Ex: pt-BR, en):</label>
            <input type="text" id="language" name="language" value="{{ old('language') }}">
        </div>

        <button type="submit" class="btn">Salvar Filme</button>
        <a href="{{ route('movies.index') }}" class="btn-back">Voltar</a>
    </form>

</body>
</html>
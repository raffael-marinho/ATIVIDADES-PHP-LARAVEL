<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource. (C - READ)
     * LISTAR: Mostra uma página com todos os filmes cadastrados.
     */
    public function index()
    {
        // Pega todos os registros da tabela 'movies' usando a Model
        $movies = Movie::all();

        // Abre a view index.blade.php (que vai estar dentro de resources/views/movies/)
        // O compact('movies') envia a variável $movies para que o HTML consiga listá-la
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource. (A - CREATE)
     * FORMULÁRIO DE CADASTRO: Só mostra a tela com o formulário vazio.
     */
    public function create()
    {
        // Abre a view create.blade.php (dentro de resources/views/movies/)
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage. (B - CREATE)
     * SALVAR NO BANCO: Recebe os dados digitados no formulário e salva.
     */
    public function store(Request $request)
    {
        // 1. Validação (Super importante para a prova! Evita dados errados no banco)
        $request->validate([
    'title'       => 'required|string|max:255',
    'description' => 'required|string',
    'duration'    => 'required|integer|min:1',
    'category'    => 'required|string',
    'budget'      => 'required|numeric|min:0',
    'language'    => 'required|string|max:5',
]);

        // 2. Salva no banco usando o Mass Assignment (as colunas do $fillable da Model)
        Movie::create($request->all());

        // 3. Redireciona o usuário para a lista de filmes com uma mensagem temporária (Flash Session)
        return redirect()->route('movies.index')->with('success', 'Filme criado com sucesso!');
    }

    /**
     * Display the specified resource. (D - READ DETALHADO)
     * EXIBIR UM FILME: Mostra os detalhes de um único filme específico.
     */
    public function show(Movie $movie)
    {
        // Graças ao 'Movie $movie' no argumento, o Laravel já buscou o filme pelo ID.
        // Só precisamos mandar para a view 'show.blade.php'
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource. (A - UPDATE)
     * FORMULÁRIO DE EDIÇÃO: Abre a tela com o formulário já preenchido com os dados atuais.
     */
    public function edit(Movie $movie)
    {
        // Mandamos o filme encontrado para a view 'edit.blade.php' preencher os inputs
        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage. (B - UPDATE)
     * SALVAR ALTERAÇÕES: Recebe os novos dados do formulário e atualiza o banco.
     */
    public function update(Request $request, Movie $movie)
    {
        // 1. Valida os dados novos recebidos
        $request->validate([
    'title'       => 'required|string|max:255',
    'description' => 'required|string',
    'duration'    => 'required|integer|min:1',
    'category'    => 'required|string',
    'budget'      => 'required|numeric|min:0',
    'language'    => 'required|string|max:5',
]);

        // 2. Atualiza o objeto do filme que o Laravel já carregou para nós
        $movie->update($request->all());

        // 3. Redireciona de volta para a listagem
        return redirect()->route('movies.index')->with('success', 'Filme atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     * DELETAR: Exclui o registro do banco de dados.
     */
    public function destroy(Movie $movie)
    {
        // Deleta o registro do banco
        $movie->delete();

        // Redireciona para a listagem avisando que deu certo
        return redirect()->route('movies.index')->with('success', 'Filme excluído com sucesso!');
    }
}
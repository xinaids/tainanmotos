<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeloController extends Controller
{
    // Exibe o formulário de cadastro
    public function create()
    {
        $fabricantes = DB::table('fabricante')->orderBy('nome')->get();
        return view('cadastrar-modelo', compact('fabricantes'));
    }

    // Salva o modelo no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'fabricante_id' => 'required|exists:fabricante,codigo',
            'nome_modelo' => 'required|string|max:40',
        ]);

        DB::table('modelo')->insert([
            'nome' => $request->input('nome_modelo'),
            'cod_fabricante' => $request->input('fabricante_id'),
        ]);

        return redirect()->back()->with('success', 'Modelo cadastrado com sucesso!');
    }

public function index(Request $request)
{
    $ordenarPor = $request->input('ordenar', 'codigo');
    $ordem = $request->input('ordem', 'asc');
    $pesquisa = $request->input('pesquisa');

    $query = DB::table('modelo')
        ->join('fabricante', 'modelo.cod_fabricante', '=', 'fabricante.codigo')
        ->select('modelo.*', 'fabricante.nome as fabricante_nome');

    if ($pesquisa) {
        $query->where('modelo.nome', 'ilike', '%' . $pesquisa . '%');
    }

    $modelos = $query->orderBy($ordenarPor, $ordem)->paginate(10)->withQueryString();

    return view('modelos.index', compact('modelos', 'ordenarPor', 'ordem'));
}

public function edit($id)
{
$modelo = DB::table('modelo')
    ->select('codigo', 'nome', 'cod_fabricante')
    ->where('codigo', $id)
    ->first();

    $fabricantes = DB::table('fabricante')->orderBy('nome')->get();

    return view('modelos.edit', compact('modelo', 'fabricantes'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nome' => 'required|string|max:100',
        'fabricante_id' => 'required|exists:fabricante,codigo',
    ]);

    DB::table('modelo')->where('codigo', $id)->update([
        'nome' => $request->input('nome'),
        'cod_fabricante' => $request->input('fabricante_id'),
    ]);

    return redirect()->route('modelo.index')->with('success', 'Modelo atualizado com sucesso!');
}



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peca;
use App\Models\Modelo;

class PecaController extends Controller
{
    public function create()
    {
        $modelos = Modelo::all();
        return view('cadastrar-peca', compact('modelos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_peca' => 'required|string|max:50',
            'preco_peca' => 'required|numeric',
            'cod_modelo' => 'required|exists:modelo,codigo',
        ]);

        Peca::create([
            'nome' => $request->nome_peca,
            'preco' => $request->preco_peca,
            'cod_modelo' => $request->cod_modelo,
        ]);

        return redirect()->route('pecas.index')->with('success', 'Peça cadastrada com sucesso!');
    }

public function index(Request $request)
{
    $ordenarPor = $request->input('ordenar_por', 'nome');
    $ordem = $request->input('ordem', 'asc');
    $pesquisa = $request->input('pesquisa');

    $pecas = Peca::with('modelo')
        ->when($pesquisa, function ($query, $pesquisa) {
            $query->whereRaw('LOWER(nome) LIKE ?', ['%' . strtolower($pesquisa) . '%']);
        })
        ->orderBy($ordenarPor, $ordem)
        ->paginate(10)
        ->appends($request->query());

    return view('pecas.index', compact('pecas'));
}

    public function edit($codigo)
{
    $peca = Peca::findOrFail($codigo);
    $modelos = Modelo::all();
    return view('pecas.edit', compact('peca', 'modelos'));
}

public function destroy($codigo)
{
    $peca = Peca::findOrFail($codigo);
    $peca->delete();
    return redirect()->route('pecas.index')->with('success', 'Peça excluída com sucesso.');
}

public function update(Request $request, $codigo)
{
    $request->validate([
        'nome' => 'required|string|max:70',
        'preco' => 'required|numeric|min:0',
        'cod_modelo' => 'required|integer|exists:modelo,codigo',
    ]);

    $peca = Peca::findOrFail($codigo);
    $peca->update($request->only(['nome', 'preco', 'cod_modelo']));

    return redirect()->route('pecas.index')->with('success', 'Peça atualizada com sucesso!');
}

public function pecasPorModelo($codModelo)
{
    return response()->json(
        Peca::where('cod_modelo', $codModelo)->get()
    );
}


}

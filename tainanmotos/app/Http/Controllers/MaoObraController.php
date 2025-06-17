<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaoObra;

class MaoObraController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $maos = MaoObra::when($busca, function ($query, $busca) {
            return $query->where('nome', 'ILIKE', "%$busca%");
        })->get();

        return view('maoobra.index', compact('maos', 'busca'));
    }


    public function create()
    {
        return view('cadastrar-mao-de-obra');
    }

    public function store(Request $request)
    {
        MaoObra::create([
            'nome' => $request->input('nome_mao_obra'),
            'valor' => $request->input('valor'),
        ]);

        return redirect()->route('maoobra.index')->with('success', 'Mão de obra cadastrada com sucesso!');
    }


    public function edit($id)
    {
        $mao = MaoObra::findOrFail($id);
        return view('maoobra.edit', compact('mao'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:60',
            'valor' => 'required|numeric|min:0',
        ]);

        $mao = MaoObra::findOrFail($id);
        $mao->update([
            'nome' => $request->input('nome'),
            'valor' => $request->input('valor'),
        ]);

        return redirect()->route('maoobra.index')->with('success', 'Mão de obra atualizada com sucesso.');
    }


    public function destroy($id)
    {
        MaoObra::destroy($id);
        return redirect()->route('maoobra.index')->with('success', 'Mão de obra excluída com sucesso.');
    }

    public function listar()
    {
        return MaoObra::select('codigo', 'nome', 'valor')->get();
    }
}

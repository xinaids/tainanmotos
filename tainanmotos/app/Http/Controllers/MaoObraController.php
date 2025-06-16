<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaoObra;

class MaoObraController extends Controller
{
    public function index()
    {
        $maos = MaoObra::all();
        return view('maoobra.index', compact('maos'));
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
        $mao = MaoObra::findOrFail($id);
        $mao->update([
            'nome' => $request->input('nome_mao_obra'),
            'valor' => $request->input('preco_mao_obra'),
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
    return MaoObra::select('nome', 'valor')->get();
}


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricanteController extends Controller
{
public function store(Request $request)
{
    // Inserir o debug aqui dentro
    DB::listen(function ($query) {
        logger($query->sql);
        logger($query->bindings);
        logger($query->time . ' ms');
    });

    $request->validate([
        'nome_fabricante' => 'required|string|max:40',
    ]);

    DB::table('fabricante')->insert([
        'nome' => $request->input('nome_fabricante'),
    ]);

    return redirect()->back()->with('success', 'Fabricante cadastrado com sucesso!');
}
public function index(Request $request)
{
    $ordenarPor = $request->input('ordenar_por', 'codigo');

    $fabricantes = DB::table('fabricante')
        ->orderBy($ordenarPor, $ordenarPor === 'nome' ? 'asc' : 'asc') // sempre ASC, mas pode trocar se quiser
        ->get();

    return view('fabricantes.index', compact('fabricantes'));
}


public function edit($id)
{
    $fabricante = DB::table('fabricante')->where('codigo', $id)->first();

    if (!$fabricante) {
        return redirect()->route('fabricante.index')->with('error', 'Fabricante não encontrado!');
    }

    return view('fabricantes.edit', compact('fabricante'));
}


public function destroy($id)
{
    DB::table('fabricante')->where('codigo', $id)->delete();
    return redirect()->route('fabricante.index')->with('success', 'Fabricante excluído com sucesso!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nome' => 'required|string|max:40',
    ]);

    DB::table('fabricante')->where('codigo', $id)->update([
        'nome' => $request->input('nome'),
    ]);

    return redirect()->route('fabricante.index')->with('success', 'Fabricante atualizado com sucesso!');
}



}

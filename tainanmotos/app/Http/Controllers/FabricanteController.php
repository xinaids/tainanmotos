<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricanteController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'nome_fabricante' => 'required|string|max:40',
    ]);

    DB::table('fabricante')->insert([
        'nome' => $request->input('nome_fabricante'),
    ]);

    // Redireciona para a tela de cadastro, não para /fabricantes
    return redirect()->route('cadastrarfabricante')->with('success', 'Fabricante cadastrado com sucesso!');
}

}



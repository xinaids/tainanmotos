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
}

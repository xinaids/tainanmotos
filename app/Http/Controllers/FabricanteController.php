<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricanteController extends Controller
{
    public function store(Request $request)
    {
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

    public function create()
    {
        if (!session()->has('usuario')) {
            return redirect()->route('login');
        }

        return view('cadastrar-fabricante');
    }


    public function index(Request $request)
    {
        if (!session()->has('usuario')) {
            return redirect()->route('login');
        }

        $ordenarPor = $request->input('ordenar_por', 'nome');
        $ordem = $request->input('ordem', 'asc');
        $pesquisa = $request->input('pesquisa');

        $query = DB::table('fabricante');

        if ($pesquisa) {
            $query->whereRaw('LOWER(nome) LIKE ?', ['%' . strtolower($pesquisa) . '%']);
        }

        $fabricantes = $query
            ->orderBy($ordenarPor, $ordem)
            ->paginate(10)
            ->appends($request->query());

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

    public function update(Request $request, $codigo)
    {
        $fabricante = DB::table('fabricante')->where('codigo', $codigo)->first();

        DB::table('fabricante')
            ->where('codigo', $codigo)
            ->update(['nome' => $request->input('nome')]);

        return redirect()->route('fabricante.index')->with('success', 'Fabricante atualizado com sucesso!');
    }
}

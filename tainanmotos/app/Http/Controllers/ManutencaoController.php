<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manutencao;
use App\Models\Moto;
use App\Models\Servico;

class ManutencaoController extends Controller
{
public function store(Request $request)
{
    if (!session()->has('usuario')) {
        return redirect()->route('login');
    }

    $request->validate([
        'placa' => 'required|max:8',
        'marca' => 'required',
        'modelo' => 'required',
        'cor' => 'required|string|max:30',
        'quilometragem' => 'required|integer|min:0',
        'ano' => 'required|integer|min:1900|max:2100',
        'descricao' => 'required|string'
    ]);

    // Verifica se a moto já existe
    $moto = Moto::where('placa', $request->placa)->first();

    if (!$moto) {
        $moto = Moto::create([
            'placa' => $request->placa,
            'cor' => $request->cor,
            'ano' => $request->ano,
            'cod_modelo' => $request->modelo
        ]);
    }

    // Cria o serviço
    Servico::create([
        'data_abertura' => now(),
        'descricao' => $request->descricao,
        'valor' => 0,
        'quilometragem' => $request->quilometragem,
        'situacao' => 1,
        'cod_moto' => $moto->codigo
    ]);

    return redirect()->route('dashboard')->with('success', 'Manutenção solicitada com sucesso!');
}   
}

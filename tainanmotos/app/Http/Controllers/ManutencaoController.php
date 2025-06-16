<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use App\Models\Servico;
use Illuminate\Support\Facades\Auth;

class ManutencaoController extends Controller
{
    public function store(Request $request)
    {
        if (!session()->has('usuario')) {
            return redirect()->route('login')->withErrors(['msg' => 'Você precisa estar logado para acessar.']);
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

        $cpfUsuario = session('usuario')['cpf'];

        // Verifica se a moto já existe
        $moto = Moto::where('placa', $request->placa)->first();

        if (!$moto) {
            $moto = Moto::create([
                'placa' => $request->placa,
                'cor' => $request->cor,
                'ano' => $request->ano,
                'cod_modelo' => $request->modelo,
                'cpf_usuario' => $cpfUsuario
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

    public function gerenciar()
    {
        $servicos = Servico::whereIn('situacao', [1, 2])
            ->with(['moto.modelo.fabricante', 'moto.usuario'])
            ->get();

        return view('gerenciar_manutencao', compact('servicos'));
    }

    public function visualizar()
    {
        $usuario = session('usuario');

        if (!$usuario) {
            return redirect()->route('login')->withErrors(['msg' => 'Você precisa estar logado para acessar.']);
        }

        $servicos = Servico::with('moto.modelo.fabricante', 'moto.usuario')
            ->whereHas('moto', function ($query) use ($usuario) {
                $query->where('cpf_usuario', $usuario['cpf']);
            })
            ->get();

        return view('visualizar_manutencao', compact('servicos'));
    }

    public function atualizarDescricao(Request $request, $id)
{
    $servico = Servico::findOrFail($id);

    $request->validate([
        'descricao' => 'required|string',
        'mao_obra_lista' => 'nullable|string' // string JSON
    ]);

    // Atualiza a descrição e situação
    $servico->descricao_manutencao = $request->descricao;
    $servico->situacao = 2;

    // Limpa as mãos de obra anteriores (se houver)
    $servico->maosObra()->detach();

    $valorTotal = 0;

    // Verifica se recebeu a lista de mãos de obra via JSON
    $maoObraIds = json_decode($request->input('mao_obra_lista'), true);

    if (is_array($maoObraIds)) {
        foreach ($maoObraIds as $idMao) {
            if ($idMao) {
                $maoObra = \App\Models\MaoObra::find($idMao);
                if ($maoObra) {
                    $servico->maosObra()->attach($maoObra->codigo, ['quantidade' => 1]); // pode ajustar a quantidade
                    $valorTotal += $maoObra->valor;
                }
            }
        }
    }

    $servico->valor = $valorTotal;
    $servico->save();

    return redirect()->route('gerenciar.manutencao')->with('success', 'Manutenção atualizada com sucesso!');
}

}

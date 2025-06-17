<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;

class ServicoController extends Controller
{

    
    public function show($id)
    {
        $servico = Servico::with(['moto.modelo.fabricante', 'maosObra']) // <<< aqui
            ->findOrFail($id);

        return response()->json($servico);
    }

    

    public function atualizar(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        // Formata e concatena a nova descrição com data/hora
        $novaDescricao = now()->format('d/m/Y H:i') . ' - ' . $request->input('descricao');

        $descricaoFinal = $servico->descricao_manutencao
            ? $servico->descricao_manutencao . "\n" . $novaDescricao
            : $novaDescricao;

        // Atualiza os campos necessários
        $servico->descricao_manutencao = $descricaoFinal;
        $servico->valor = floatval(str_replace(['R$', ','], ['', '.'], $request->input('valor')));
        $servico->data_fechamento = $request->input('data_fechamento') ?: null;

        // Atualiza a situação
        $mapSituacao = [
            'Pendente' => 1,
            'Em andamento' => 2,
            'Concluído' => 3
        ];
        $servico->situacao = $mapSituacao[$request->input('situacao')] ?? 1;

        $servico->save();

        return redirect()->route('manutencao.gerenciar')->with('success', 'Serviço atualizado com sucesso!');
    }

   
}

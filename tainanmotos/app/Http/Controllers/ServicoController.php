<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Servico;

class ServicoController extends Controller
{
    // 🔍 Mostra os dados completos de um serviço
    public function show($id)
    {
        $servico = Servico::with([
            'moto.modelo.fabricante',
            'moto.modelo',
            'moto.usuario',
            'maosObra'
        ])->findOrFail($id);

        return response()->json($servico);
    }

    // 💾 Atualiza campos do serviço: situação, valor e histórico
    public function atualizar(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        // Histórico formatado com data/hora
        $novaDescricao = now()->format('d/m/Y H:i') . ' - ' . $request->input('descricao');
        $descricaoFinal = $servico->descricao_manutencao
            ? $servico->descricao_manutencao . "\n" . $novaDescricao
            : $novaDescricao;

        $servico->descricao_manutencao = $descricaoFinal;

        // Atualiza valor (tratando formato brasileiro R$)
        $servico->valor = floatval(str_replace(['R$', ',', ' '], ['', '.', ''], $request->input('valor')));

        // Data de fechamento (se fornecida)
        $servico->data_fechamento = $request->input('data_fechamento') ?: null;

        // Mapeia texto da situação para número
        $mapSituacao = [
            'Pendente' => 1,
            'Em andamento' => 2,
            'Concluído' => 3
        ];
        $servico->situacao = $mapSituacao[$request->input('situacao')] ?? 1;

        $servico->save();

        return redirect()->route('manutencao.gerenciar')->with('success', 'Serviço atualizado com sucesso!');
    }

    // 🛠 Atualiza histórico e salva lista de mão de obra associada
    public function atualizarDescricao(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        // Atualiza descrição
        $servico->descricao_manutencao = $request->input('descricao_historico');

        // Decodifica lista de mão de obra (JSON do front)
        $listaJson = $request->input('mao_obra_lista');
        $listaMaoObra = $listaJson ? json_decode($listaJson, true) : [];

        // Remove vínculos antigos
        DB::table('servico_maodeobra')->where('cod_servico', $servico->codigo)->delete();

        // Reinsere e soma os valores
        $valorTotal = 0;
        foreach ($listaMaoObra as $mao) {
            DB::table('servico_maodeobra')->insert([
                'cod_servico' => $servico->codigo,
                'cod_maodeobra' => $mao['codigo'],
                'quantidade' => 1
            ]);

            $valorTotal += floatval($mao['valor']);
        }

        // Atualiza valor final no serviço
        $servico->valor = $valorTotal;
        $servico->save();

        return redirect()->route('manutencao.gerenciar')->with('success', 'Manutenção atualizada com sucesso!');
    }
}

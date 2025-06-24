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
            'maosObra',
            'pecas' // RELACIONAMENTO DEFINIDO NO MODEL
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

    // 🛠 Atualiza histórico e salva lista de mão de obra e peças associadas
    public function atualizarDescricao(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        // Atualiza a descrição
        $servico->descricao_manutencao = $request->input('descricao_historico');

        // ===== 1. Salvar MÃO DE OBRA =====
        $listaMaoObra = $request->input('mao_obra_lista');
        $listaMaoObra = $listaMaoObra ? json_decode($listaMaoObra, true) : [];

        DB::table('servico_maodeobra')->where('cod_servico', $servico->codigo)->delete();

        $valorMaoObra = 0;
        foreach ($listaMaoObra as $mao) {
            DB::table('servico_maodeobra')->insert([
                'cod_servico' => $servico->codigo,
                'cod_maodeobra' => $mao['codigo'],
                'quantidade' => 1
            ]);
            $valorMaoObra += floatval($mao['valor']);
        }

        // ===== 2. Salvar PEÇAS =====
        $listaPecas = $request->input('peca_lista');
        $listaPecas = $listaPecas ? json_decode($listaPecas, true) : [];

        DB::table('servico_peca')->where('cod_servico', $servico->codigo)->delete();

        $valorPecas = 0;
        foreach ($listaPecas as $peca) {
            $quantidade = $peca['quantidade'] ?? 1;

            DB::table('servico_peca')->insert([
                'cod_servico' => $servico->codigo,
                'cod_peca' => $peca['codigo'],
                'quantidade' => $quantidade
            ]);

            $valorPecas += floatval($peca['preco']) * $quantidade;
        }

        // ===== 3. Atualiza valor total =====
        $servico->valor = $valorMaoObra + $valorPecas;
        $servico->save();

        return redirect()->route('manutencao.gerenciar')->with('success', 'Manutenção atualizada com sucesso!');
    }
}

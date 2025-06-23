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

        // 🔹 Busca peças associadas ao serviço
        $pecas = DB::table('servico_peca')
            ->join('peca', 'servico_peca.cod_peca', '=', 'peca.codigo')
            ->where('servico_peca.cod_servico', $servico->codigo)
            ->select('peca.codigo', 'peca.nome', 'peca.preco')
            ->get();

        // 🔸 Inclui no JSON final
        return response()->json([
            'codigo' => $servico->codigo,
            'data_abertura' => $servico->data_abertura,
            'data_fechamento' => $servico->data_fechamento,
            'descricao_manutencao' => $servico->descricao_manutencao,
            'situacao' => $servico->situacao,
            'valor' => $servico->valor,
            'quilometragem' => $servico->quilometragem,
            'moto' => $servico->moto,
            'maos_obra' => $servico->maosObra,
            'pecas' => $pecas,
        ]);
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
            DB::table('servico_peca')->insert([
                'cod_servico' => $servico->codigo,
                'cod_peca' => $peca['codigo'],
                'quantidade' => 1
            ]);
            $valorPecas += floatval($peca['preco']);
        }

        // ===== 3. Atualiza valor total =====
        $servico->valor = $valorMaoObra + $valorPecas;
        $servico->save();

        return redirect()->route('manutencao.gerenciar')->with('success', 'Manutenção atualizada com sucesso!');
    }
}

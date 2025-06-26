<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Servico; // Certifique-se de importar o modelo Servico
use App\Models\Peca;    // Certifique-se de importar o modelo Peca
use App\Models\MaoObra; // Certifique-se de importar o modelo MaoObra


class ServicoController extends Controller
{
    /**
     * Mostra os dados completos de um serviço específico.
     * Inclui as relações de moto, modelo, fabricante, usuário,
     * mão de obra e peças com suas quantidades.
     *
     * @param  int  $id O código do serviço.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $servico = Servico::with([
            'moto.modelo.fabricante',
            'moto.usuario',
            'maosObra', // Carrega a relação de mão de obra
            'pecas' => function($query) {
                $query->withPivot('quantidade'); // Carrega a relação de peças e o campo 'quantidade' da tabela pivot
            }
        ])->findOrFail($id);

        return response()->json($servico);
    }

    /**
     * Atualiza campos do serviço: situação, valor e histórico.
     * Este método é diferente do `atualizarDescricao` em ManutencaoController.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
        $servico->valor = floatval(str_replace(['R$', ',', ' '], ['', '.', ''], $request->input('valor_total')));

        // ===== 1. Salvar MÃO DE OBRA =====
        $listaMaoObra = $request->input('mao_obra_lista');
        $listaMaoObra = $listaMaoObra ? json_decode($listaMaoObra, true) : [];

        // Detach todas as mãos de obra existentes para sincronizar
        $servico->maosObra()->detach();

        foreach ($listaMaoObra as $mao) {
            // Verifica se a mão de obra existe antes de anexar
            $maoObraExistente = MaoObra::find($mao['codigo']);
            if ($maoObraExistente) {
                $servico->maosObra()->attach($mao['codigo'], ['quantidade' => 1]);
            }
        }

        // ===== 2. Salvar PEÇAS =====
        $listaPecas = $request->input('peca_lista');
        $listaPecas = $listaPecas ? json_decode($listaPecas, true) : [];

        // Detach todas as peças existentes para sincronizar
        $servico->pecas()->detach();

        foreach ($listaPecas as $peca) {
            $quantidade = $peca['quantidade'] ?? 1;
            // Verifica se a peça existe antes de anexar
            $pecaExistente = Peca::find($peca['codigo']);
            if ($pecaExistente) {
                $servico->pecas()->attach($peca['codigo'], ['quantidade' => $quantidade]);
            }
        }

        $servico->save();

        return redirect()->back()->with('success', 'Serviço atualizado com sucesso!');
    }
}
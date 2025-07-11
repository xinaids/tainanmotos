<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use App\Models\Servico;
use App\Models\Peca; // Certifique-se de que o modelo Peca está importado
use App\Models\MaoObra; // Certifique-se de que o modelo MaoObra está importado
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Importe a classe Carbon para manipulação de datas

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
        // Alterado para incluir a situação 3 (Concluído) se desejar gerenciar também
        $servicos = Servico::whereIn('situacao', [1, 2, 3])
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

        // Validação dos dados, agora incluindo 'situacao' e 'data_fechamento'
        $request->validate([
            'situacao' => 'required|integer|in:1,2,3', // 1=Pendente, 2=Em andamento, 3=Concluído
            'data_fechamento' => 'nullable|date',
            'descricao_historico' => 'nullable|string', // Nome do campo do frontend
            'mao_obra_lista' => 'nullable|json',
            'peca_lista' => 'nullable|json'
        ]);

        // Atualiza a situação do serviço com o valor do formulário
        $servico->situacao = $request->input('situacao');

        // Lógica para definir ou limpar a data de fechamento
        if ($servico->situacao == 3) { // Se a situação for "Concluído" (valor 3)
            // Se data_fechamento foi enviada, usa ela. Senão, usa a data/hora atual.
            $servico->data_fechamento = $request->input('data_fechamento') ?
                                        Carbon::parse($request->input('data_fechamento')) :
                                        Carbon::now();
        } else {
            // Se a situação não for "Concluído", a data de fechamento deve ser nula
            $servico->data_fechamento = null;
        }

        // Atualiza a descrição de manutenção com o histórico completo
        // O campo 'descricao_manutencao' no banco de dados armazena o histórico completo
        $servico->descricao_manutencao = $request->input('descricao_historico');

        $valorTotal = 0;

        // Processa e sincroniza Mão de Obra
        $maoObraItens = json_decode($request->input('mao_obra_lista', '[]'), true);
        $syncDataMaoDeObra = [];
        if (is_array($maoObraItens)) {
            foreach ($maoObraItens as $item) {
                $idMao = $item['codigo'] ?? null;
                if ($idMao) {
                    $maoObra = MaoObra::find($idMao); // Encontra a mão de obra pelo ID
                    if ($maoObra) {
                        // Adiciona ao array para sincronização. Quantidade assume 1 por item de mão de obra.
                        $syncDataMaoDeObra[$maoObra->codigo] = ['quantidade' => 1];
                        $valorTotal += $maoObra->valor; // Soma o valor real do banco de dados
                    }
                }
            }
        }
        // Sincroniza o relacionamento. Isso remove as antigas e adiciona as novas ou atualiza as existentes.
        $servico->maosObra()->sync($syncDataMaoDeObra);

        // Processa e sincroniza Peças
        $pecas = json_decode($request->input('peca_lista', '[]'), true);
        $syncDataPecas = [];
        if (is_array($pecas)) {
            foreach ($pecas as $peca) {
                $idPeca = $peca['codigo'] ?? null;
                $quantidadePeca = $peca['quantidade'] ?? 1; // Pega a quantidade do JSON do frontend
                if ($idPeca) {
                    $pecaModel = Peca::find($idPeca); // Encontra a peça pelo ID
                    if ($pecaModel) {
                        // Adiciona ao array para sincronização, com a quantidade correta
                        $syncDataPecas[$pecaModel->codigo] = ['quantidade' => $quantidadePeca];
                        $valorTotal += ($pecaModel->preco * $quantidadePeca); // Soma o valor real do banco de dados
                    }
                }
            }
        }
        // Sincroniza o relacionamento das peças
        $servico->pecas()->sync($syncDataPecas);

        // Atualiza o valor total no serviço
        $servico->valor = $valorTotal;
        $servico->save(); // Salva todas as alterações no serviço

        return redirect()->route('gerenciar.manutencao')->with('success', 'Manutenção atualizada com sucesso!');
    }
}
@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Gerenciar Manutenções</h2>
    <p>Acompanhe e administre as manutenções em aberto no sistema.</p>

    {{-- BUSCA / FILTROS --}}
    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Buscar...">
        <select id="search-type" name="search-type" style="appearance:none;background-image:none;">
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="nome">Nome do Cliente</option>
        </select>

        <select id="filtroSituacao" name="filtroSituacao">
            <option value="todas">Todas</option>
            <option value="pendente">Pendentes</option>
            <option value="em_andamento">Em andamento</option>
            <option value="concluido">Concluídas</option>
        </select>
    </div>

    {{-- TABELA --}}
    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Nome do Cliente</th>
                <th>Data de Abertura</th>
                <th>Situação</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicos as $servico)
            <tr
                data-modelo="{{ $servico->moto->modelo->nome ?? '' }}"
                data-marca="{{ $servico->moto->modelo->fabricante->nome ?? '' }}"
                data-data_abertura="{{ \Carbon\Carbon::parse($servico->data_abertura)->format('Y-m-d') }}"
                data-situacao="{{ match($servico->situacao){1=>'pendente',2=>'em_andamento',3=>'concluido',default=>''} }}">
                <td>{{ $servico->moto->modelo->nome ?? '-' }}</td>
                <td>{{ $servico->moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $servico->moto->usuario->nome ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d/m/Y') }}</td>
                <td>{{ ['1'=>'Pendente','2'=>'Em andamento','3'=>'Concluído'][$servico->situacao] ?? '-' }}</td>
                <td><a href="#" class="btn-visualizar" data-id="{{ $servico->codigo }}"><i class="fas fa-search"></i> Ver Detalhes</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
</div>

{{-- MODAL DETALHES --}}
<div id="modalDetalhes" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3>Detalhes da Manutenção</h3>

        <form id="formDetalhes" class="modal-form" method="POST" onsubmit="return prepararEnvioDescricao();">
            <input type="hidden" name="descricao_historico" id="descricao_historico_hidden">
            @csrf

            {{-- linha 1 - agora com VALOR ao lado de Situação --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="data_abertura">Data Abertura</label>
                    <input type="date" id="data_abertura" name="data_abertura" readonly>
                </div>
                <div class="form-group">
                    <label for="data_fechamento">Data Fechamento</label>
                    <input type="date" id="data_fechamento" name="data_fechamento">
                </div>
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select id="situacao" name="situacao">
                        <option value="1">Pendente</option>
                        <option value="2">Em andamento</option>
                        <option value="3">Concluído</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input id="valor" name="valor" value="R$ 0,00" readonly>
                </div>
            </div>


            {{-- linha 2 --}}
            <div class="form-row">
                <div class="form-group"><label>Fabricante</label><input id="fabricante_moto" name="fabricante_moto" readonly></div>
                <div class="form-group"><label>Modelo</label><input id="modelo_moto" name="modelo_moto" readonly></div>
                <div class="form-group"><label>Placa</label><input id="placa_moto" name="placa_moto" readonly></div>
                <div class="form-group"><label>Ano</label><input id="ano_moto" name="ano_moto" readonly></div>
                <div class="form-group"><label>Quilometragem</label><input id="quilometragem" name="quilometragem" readonly></div>
            </div>

            {{-- linha 3 - MÃO DE OBRA + PEÇAS --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="mao_obra">Atribuir Mão de Obra</label>
                    <select id="mao_obra" name="mao_obra"></select>
                    <div style="margin-top:8px;display:flex;gap:8px;">
                        <button type="button" class="btn-plus" id="btnAdicionarMaoObra">Adicionar</button>
                    </div>
                    <ul id="listaMaoObra" style="margin-top:10px;padding-left:20px;list-style-type:disc;"></ul>
                    <input type="hidden" id="mao_obra_lista" name="mao_obra_lista">
                </div>

                <div class="form-group">
                    <label for="peca">Atribuir Peça</label>
                    <select id="peca" name="peca"></select>
                    <div style="margin-top:8px;display:flex;gap:8px;">
                        <button type="button" class="btn-plus" id="btnAdicionarPeca">Adicionar</button>
                    </div>
                    <ul id="listaPecas" style="margin-top:10px;padding-left:20px;list-style-type:disc;"></ul>
                    <input type="hidden" id="peca_lista" name="peca_lista">
                </div>
            </div>




            {{-- linha 4 --}}
            <div class="form-row">
                <div class="form-group"><label>Descrição</label><textarea id="descricao" name="descricao" rows="4"></textarea></div>
                <div class="form-group"><label>Histórico de Descrições</label><textarea id="descricao_historico" rows="6" readonly style="background:#f5f5f5;"></textarea></div>
            </div>

            {{-- linha 5 --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Mão de Obra Registrada</label>
                    <ul id="maoObraRegistrada" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Nenhuma mão de obra registrada.</em></li>
                    </ul>
                </div>
            </div>

            {{-- linha 6 -- PEÇAS REGISTRADAS --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Peças Registradas</label>
                    <ul id="pecasRegistradas" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Nenhuma peça registrada.</em></li>
                    </ul>
                </div>
            </div>



            <div class="form-row" style="justify-content:flex-end;">
                <button type="submit" class="btn-enviar"><i class="fas fa-paper-plane"></i> Enviar Manutenção</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HISTÓRICO --}}
<div id="modalHistorico" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModalHistorico()">&times;</span>
        <h3>Histórico de Descrições</h3>
        <div id="historicoDescricao" style="max-height:300px;overflow-y:auto;padding:10px;background:#f9f9f9;border:1px solid #ccc;border-radius:8px;">
            <ul id="listaHistorico"></ul>
        </div>
    </div>
</div>


<script>
    let pecasDisponiveis = [];
    let pecasAdicionadas = []; // Peças adicionadas NA SESSÃO ATUAL do modal (as que você vai enviar)

    let maoDeObraDisponiveis = [];
    let maoDeObraAdicionadas = []; // Mão de obra adicionadas NA SESSÃO ATUAL do modal

    function abrirModal(modelo, marca, dataAbertura) {
        document.getElementById("modalDetalhes").style.display = "flex";
        // Estes campos são apenas para exibição no modal
        document.getElementById("modelo_moto").value = modelo;
        document.getElementById("fabricante_moto").value = marca;
        document.getElementById("data_abertura").value = dataAbertura;
        document.getElementById("situacao").value = "1"; // Default para Pendente
        // Limpar as listas de peças e mão de obra ao abrir um novo modal ou reabrir
        document.getElementById("listaPecas").innerHTML = "";
        document.getElementById("listaMaoObra").innerHTML = "";
        document.getElementById("pecasRegistradas").innerHTML = "<li><em>Nenhuma peça registrada.</em></li>";
        document.getElementById("maoObraRegistrada").innerHTML = "<li><em>Nenhuma mão de obra registrada.</em></li>";

        pecasAdicionadas = [];
        maoDeObraAdicionadas = [];
        atualizarValorTotal();
    }

    function fecharModal() {
        document.getElementById("modalDetalhes").style.display = "none";
    }

    function fecharModalHistorico() {
        document.getElementById("modalHistorico").style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarMaoDeObra(); // Carrega as opções de mão de obra ao carregar a página

        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idServico = this.getAttribute('data-id');

                // Limpa as listas e arrays ao abrir para um novo serviço
                document.getElementById("listaPecas").innerHTML = "";
                document.getElementById("listaMaoObra").innerHTML = "";
                pecasAdicionadas = [];
                maoDeObraAdicionadas = [];


                fetch(`/servico/${idServico}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Preenche os campos do modal com os dados do serviço
                        document.getElementById("data_abertura").value = data.data_abertura;
                        document.getElementById("data_fechamento").value = data.data_fechamento ?? "";
                        document.getElementById("descricao_historico").value = data.descricao_manutencao ?? "";
                        document.getElementById("situacao").value = data.situacao; // Usar o valor numérico da situação

                        document.getElementById("fabricante_moto").value = data.moto.modelo.fabricante.nome;
                        document.getElementById("modelo_moto").value = data.moto.modelo.nome;
                        document.getElementById("placa_moto").value = data.moto.placa;
                        document.getElementById("ano_moto").value = data.moto.ano;
                        document.getElementById("quilometragem").value = data.quilometragem;
                        document.getElementById("descricao").value = ""; // Limpa o campo de nova descrição

                        // Carrega as peças disponíveis para o modelo da moto
                        if (data.moto.modelo.codigo) {
                            carregarPecas(data.moto.modelo.codigo);
                        }

                        // Carrega e exibe as peças já registradas no serviço
                        carregarPecasRegistradas(data);

                        // Carrega e exibe as mão de obra já registradas no serviço
                        carregarMaoObraRegistrada(data);

                        // Atualiza a rota do formulário para o serviço específico
                        document.getElementById("formDetalhes").action = `/manutencao/${data.codigo}/descricao`;

                        // Exibe o modal
                        document.getElementById("modalDetalhes").style.display = "flex";
                        atualizarValorTotal(); // Calcula o valor total inicial
                    })
                    .catch(error => {
                        console.error("Erro ao carregar detalhes do serviço:", error);
                        alert("Erro ao carregar dados da manutenção.");
                    });
            });
        });
    });


    function prepararEnvioDescricao() {
        const descricaoInput = document.getElementById("descricao");
        const historicoTextarea = document.getElementById("descricao_historico");
        const pecaListaHidden = document.getElementById("peca_lista");
        const maoObraListaHidden = document.getElementById("mao_obra_lista");

        // Atualiza os campos ocultos com os JSONs corretos das peças e mão de obra a serem adicionadas/removidas
        pecaListaHidden.value = JSON.stringify(pecasAdicionadas);
        maoObraListaHidden.value = JSON.stringify(maoDeObraAdicionadas);

        // Lógica para adicionar nova descrição ao histórico
        const novaDescricao = descricaoInput.value.trim();
        if (novaDescricao) {
            const dataAtual = new Date();
            const dataFormatada = dataAtual.toLocaleString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const novaEntrada = `[${dataFormatada}] ${novaDescricao}`;
            const historicoAtual = historicoTextarea.value.trim();
            const novoHistorico = historicoAtual ? `${historicoAtual}\n${novaEntrada}` : novaEntrada;

            historicoTextarea.value = novoHistorico; // Atualiza o textarea visível
            // Atualiza o input hidden para ser enviado ao servidor
            document.getElementById("descricao_historico_hidden").value = novoHistorico;
        } else {
            // Se não houver nova descrição, apenas garante que o histórico existente seja enviado
            document.getElementById("descricao_historico_hidden").value = historicoTextarea.value;
        }

        return true; // Prossegue com o envio do formulário
    }


    document.getElementById('filtroSituacao').addEventListener('change', function() {
        const filtro = this.value;

        document.querySelectorAll('table.manutencao-table tbody tr').forEach(row => {
            const situacao = row.getAttribute('data-situacao');
            const deveMostrar = (
                filtro === 'todas' || filtro === situacao
            );

            row.style.display = deveMostrar ? '' : 'none';
        });
    });

    // Função para carregar peças disponíveis para um dado modelo
    function carregarPecas(codModelo) {
        const select = document.getElementById("peca");
        fetch(`/api/pecas/${codModelo}`)
            .then(res => res.json())
            .then(data => {
                pecasDisponiveis = data; // Armazena as peças disponíveis
                select.innerHTML = ''; // Limpa as opções existentes
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Nenhuma peça disponível para este modelo';
                    select.appendChild(option);
                    select.disabled = true;
                    document.getElementById('btnAdicionarPeca').disabled = true;
                } else {
                    select.disabled = false;
                    document.getElementById('btnAdicionarPeca').disabled = false;
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.codigo;
                        option.textContent = `${item.nome} - R$ ${parseFloat(item.preco).toFixed(2).replace(".", ",")}`;
                        option.dataset.nome = item.nome;
                        option.dataset.preco = item.preco;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error("Erro ao carregar peças disponíveis:", error);
                select.innerHTML = '<option value="">Erro ao carregar peças</option>';
                select.disabled = true;
                document.getElementById('btnAdicionarPeca').disabled = true;
            });
    }

    // Adiciona peça à lista de peças "a atribuir" (listaPecas)
    document.getElementById('btnAdicionarPeca').addEventListener('click', () => {
        const select = document.getElementById('peca');
        const codigo = parseInt(select.value, 10);
        if (!codigo) return;

        const pecaSelecionada = pecasDisponiveis.find(p => p.codigo === codigo);
        if (!pecaSelecionada) {
            alert('Peça inválida.');
            return;
        }

        const existente = pecasAdicionadas.find(p => p.codigo === codigo);
        if (existente) {
            existente.quantidade += 1;
        } else {
            pecasAdicionadas.push({
                codigo: pecaSelecionada.codigo,
                nome: pecaSelecionada.nome,
                preco: parseFloat(pecaSelecionada.preco),
                quantidade: 1
            });
        }
        atualizarListaPecasParaAtribuir();
    });


    function atualizarListaPecasParaAtribuir() {
        const ul = document.getElementById("listaPecas");
        ul.innerHTML = ""; // Limpa a lista antes de redesenhar

        pecasAdicionadas.forEach((peca, index) => {
            const li = document.createElement("li");
            li.textContent = `${peca.nome} - R$ ${(peca.preco * peca.quantidade).toFixed(2).replace('.', ',')} (x${peca.quantidade})`;

            const btnRemover = document.createElement("button");
            btnRemover.textContent = "✖";
            btnRemover.style.cssText = "margin-left:10px;background:none;border:none;color:red;cursor:pointer";
            btnRemover.onclick = () => {
                if (peca.quantidade > 1) {
                    peca.quantidade -= 1;
                } else {
                    pecasAdicionadas.splice(index, 1);
                }
                atualizarListaPecasParaAtribuir(); // Atualiza a lista e o total
            };

            li.appendChild(btnRemover);
            ul.appendChild(li);
        });

        atualizarValorTotal(); // Recalcula o valor total
        document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
    }


    function atualizarValorTotal() {
        const totalMao = maoDeObraAdicionadas.reduce((soma, item) => soma + parseFloat(item.valor), 0);
        const totalPeca = pecasAdicionadas.reduce((soma, item) => soma + (parseFloat(item.preco) * item.quantidade), 0);
        const totalGeral = totalMao + totalPeca;

        document.getElementById("valor").value = "R$ " + totalGeral.toFixed(2).replace(".", ",");
    }

    function carregarMaoDeObra() {
        const select = document.getElementById("mao_obra");
        fetch('/api/mao-de-obra')
            .then(res => res.json())
            .then(data => {
                maoDeObraDisponiveis = data;
                select.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.codigo;
                    option.textContent = `${item.nome} - R$ ${parseFloat(item.valor).toFixed(2).replace(".", ",")}`;
                    option.dataset.nome = item.nome;
                    option.dataset.valor = item.valor;
                    select.appendChild(option);
                });
            });
    }

    // Adiciona mão de obra à lista de mão de obra "a atribuir" (listaMaoObra)
    document.getElementById('btnAdicionarMaoObra').addEventListener('click', () => {
        const select = document.getElementById('mao_obra');
        const codigo = parseInt(select.value, 10);
        if (!codigo) return;

        const maoSelecionada = maoDeObraDisponiveis.find(m => m.codigo === codigo);
        if (!maoSelecionada) return;

        if (maoDeObraAdicionadas.some(m => m.codigo === codigo)) {
            alert('Essa mão de obra já foi adicionada.');
            return;
        }

        maoDeObraAdicionadas.push({
            codigo: maoSelecionada.codigo,
            nome: maoSelecionada.nome,
            valor: parseFloat(maoSelecionada.valor)
        });

        atualizarListaMaoDeObraParaAtribuir();
    });

    function atualizarListaMaoDeObraParaAtribuir() {
        const ul = document.getElementById("listaMaoObra");
        ul.innerHTML = "";

        maoDeObraAdicionadas.forEach((mao, index) => {
            const li = document.createElement('li');
            li.textContent = `${mao.nome} - R$ ${mao.valor.toFixed(2).replace('.', ',')}`;

            const btnX = document.createElement('button');
            btnX.textContent = '✖';
            btnX.style.cssText = 'margin-left:10px;background:none;border:none;color:red;cursor:pointer';
            btnX.onclick = () => {
                maoDeObraAdicionadas.splice(index, 1);
                atualizarListaMaoDeObraParaAtribuir();
                atualizarValorTotal();
            };

            li.appendChild(btnX);
            ul.appendChild(li);
        });
        atualizarValorTotal();
        document.getElementById("mao_obra_lista").value = JSON.stringify(maoDeObraAdicionadas);
    }


    function carregarMaoObraRegistrada(data) {
        const ulMaoObra = document.getElementById("maoObraRegistrada");
        ulMaoObra.innerHTML = "";
        maoDeObraAdicionadas = []; // Limpa a lista antes de popular

        if (data.maos_obra && data.maos_obra.length > 0) {
            data.maos_obra.forEach(m => {
                // Adiciona as mãos de obra registradas ao array maoDeObraAdicionadas
                maoDeObraAdicionadas.push({
                    codigo: m.codigo,
                    nome: m.nome,
                    valor: parseFloat(m.valor)
                });

                const li = document.createElement("li");
                li.textContent = `${m.nome} - R$ ${parseFloat(m.valor).toFixed(2).replace(".", ",")}`;

                const btnRemover = document.createElement("button");
                btnRemover.textContent = "✖";
                btnRemover.style.marginLeft = "10px";
                btnRemover.style.background = "none";
                btnRemover.style.border = "none";
                btnRemover.style.color = "red";
                btnRemover.style.cursor = "pointer";

                btnRemover.onclick = () => {
                    maoDeObraAdicionadas = maoDeObraAdicionadas.filter(mao => mao.codigo !== m.codigo);
                    carregarMaoObraRegistrada({ maos_obra: maoDeObraAdicionadas }); // Recarrega a lista visual
                };

                li.appendChild(btnRemover);
                ulMaoObra.appendChild(li);
            });
            document.getElementById("mao_obra_lista").value = JSON.stringify(maoDeObraAdicionadas);
        } else {
            const li = document.createElement("li");
            li.innerHTML = "<em>Nenhuma mão de obra registrada.</em>";
            ulMaoObra.appendChild(li);
            document.getElementById("mao_obra_lista").value = "[]";
        }
        atualizarValorTotal();
    }


    function carregarPecasRegistradas(data) {
        const ulPecas = document.getElementById("pecasRegistradas");
        ulPecas.innerHTML = ""; // Limpa a lista antes de popular
        pecasAdicionadas = []; // Limpa a lista de peças a serem enviadas

        if (data.pecas && data.pecas.length > 0) {
            data.pecas.forEach((p) => {
                const item = {
                    codigo: p.codigo,
                    nome: p.nome,
                    preco: parseFloat(p.preco),
                    quantidade: p.pivot?.quantidade || 1 // Certifica-se de pegar a quantidade do pivot
                };
                pecasAdicionadas.push(item);

                const li = document.createElement("li");
                li.textContent = `${item.nome} - R$ ${(item.preco * item.quantidade).toFixed(2).replace(".", ",")} (x${item.quantidade})`;

                const btnRemover = document.createElement("button");
                btnRemover.textContent = "✖";
                btnRemover.style.cssText = "margin-left:10px;background:none;border:none;color:red;cursor:pointer";
                btnRemover.onclick = () => {
                    // Encontra o índice da peça para remoção
                    const indexToRemove = pecasAdicionadas.findIndex(pa => pa.codigo === item.codigo);
                    if (indexToRemove > -1) {
                        if (pecasAdicionadas[indexToRemove].quantidade > 1) {
                            pecasAdicionadas[indexToRemove].quantidade -= 1;
                        } else {
                            pecasAdicionadas.splice(indexToRemove, 1);
                        }
                    }
                    // Recarrega a exibição das peças registradas para refletir a mudança
                    carregarPecasRegistradas({ pecas: pecasAdicionadas.map(p => ({
                        codigo: p.codigo,
                        nome: p.nome,
                        preco: p.preco,
                        pivot: { quantidade: p.quantidade }
                    }))});
                };

                li.appendChild(btnRemover);
                ulPecas.appendChild(li);
            });
            document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
        } else {
            const li = document.createElement("li");
            li.innerHTML = "<em>Nenhuma peça registrada.</em>";
            ulPecas.appendChild(li);
            document.getElementById("peca_lista").value = "[]";
        }
        atualizarValorTotal();
    }
</script>


<style>
    /* ---------- LAYOUT GERAL ---------- */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        margin: 0
    }

    .gerenciar-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1)
    }

    h2 {
        font-size: 26px;
        margin: 0 0 5px
    }

    .fade-in {
        animation: fadeIn .6s ease-in-out
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    /* ---------- FILTRO ---------- */
    .search-container {
        margin: 20px 0;
        display: flex;
        gap: 10px;
        flex-wrap: wrap
    }

    .search-container input,
    .search-container select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: .3s
    }

    .search-container input:focus,
    .search-container select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, .3);
        outline: none
    }

    /* ---------- TABELA ---------- */
    .manutencao-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden
    }

    .manutencao-table th,
    .manutencao-table td {
        padding: 12px 15px;
        font-size: 14px;
        border-bottom: 1px solid #eee;
        text-align: left
    }

    .manutencao-table th {
        background: #f0f2f5;
        font-weight: bold
    }

    .manutencao-table tr:hover {
        background: #f9f9f9
    }

    /* ---------- BOTÕES ---------- */
    .btn-visualizar,
    .btn-voltar,
    .btn-concluir {
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: .3s
    }

    .btn-visualizar {
        background: #ffe633;
        color: #333
    }

    .btn-visualizar:hover {
        background: #ffdd00;
        transform: translateY(-2px)
    }

    .btn-concluir {
        background: #4caf50;
        color: #fff
    }

    .btn-concluir:hover {
        background: #43a047;
        transform: translateY(-2px)
    }

    .btn-voltar {
        margin-top: 20px;
        background: #2196f3;
        color: #fff
    }

    .btn-voltar:hover {
        background: #1976d2;
        transform: translateY(-2px)
    }

    /* ---------- MODAL OVERLAY ---------- */
    .modal-overlay {
        position: fixed;
        inset: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, .5);
        z-index: 999
    }

    /* ---------- MODAL CONTENT ---------- */
    .modal-overlay .modal-content {
        width: 90vw !important;
        /* ocupa 90% da viewport */
        max-width: 1400px !important;
        /* limite para monitores grandes */
        max-height: 90vh;
        /* evita estourar a altura */
        overflow-y: auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
        animation: fadeIn .3s;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #555
    }

    /* ---------- FORM NO MODAL ---------- */
    .modal-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 20px
    }

    .modal-form .form-group {
        display: flex;
        flex-direction: column;
        width: 100%
    }

    .modal-form label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333
    }

    .modal-form input,
    .modal-form textarea,
    .modal-form select {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #fff;
        transition: border-color .3s
    }

    .modal-form input:focus,
    .modal-form textarea:focus,
    .modal-form select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, .3);
        outline: none
    }

    /* ---------- BOTÕES NO MODAL ---------- */
    .btn-plus {
        padding: 10px 12px;
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: .3s
    }

    .btn-plus:hover {
        background: #115293
    }

    .btn-enviar {
        padding: 12px 20px;
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .3s
    }

    .btn-enviar:hover {
        background: #115293;
        transform: translateY(-2px)
    }

    /* ---------- LISTAS DE MÃO DE OBRA ---------- */
    #listaMaoObra li,
    #maoObraRegistrada li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-right: 10px
    }

    #listaMaoObra li button,
    #maoObraRegistrada li button {
        background: none;
        border: none;
        color: red;
        font-weight: bold;
        cursor: pointer
    }
</style>
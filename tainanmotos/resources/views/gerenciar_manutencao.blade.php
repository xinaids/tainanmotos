@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Gerenciar Manutenções</h2>
    <p>Acompanhe e administre as manutenções em aberto no sistema.</p>

    {{-- ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­ BUSCA / FILTROS --}}
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

    {{-- ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­ TABELA --}}
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

{{-- ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­ MODAL DETALHES --}}
<div id="modalDetalhes" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3>Detalhes da Manutenção</h3>

        <form id="formDetalhes" class="modal-form" method="POST" onsubmit="return prepararEnvioDescricao();">
            @csrf

            {{-- linha 1 - agora com VALOR ao lado de Situação --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="data_abertura">Data Abertura</label>
                    <input type="date" id="data_abertura" name="data_abertura">
                </div>
                <div class="form-group">
                    <label for="data_fechamento">Data Fechamento</label>
                    <input type="date" id="data_fechamento" name="data_fechamento">
                </div>
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select id="situacao" name="situacao">
                        <option>Pendente</option>
                        <option>Em andamento</option>
                        <option>Concluído</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input id="valor" name="valor" value="R$ 0,00" readonly>
                </div>
            </div>


            {{-- linha 2 --}}
            <div class="form-row">
                <div class="form-group"><label>Fabricante</label><input id="fabricante_moto" name="fabricante_moto"></div>
                <div class="form-group"><label>Modelo</label><input id="modelo_moto" name="modelo_moto"></div>
                <div class="form-group"><label>Placa</label><input id="placa_moto" name="placa_moto"></div>
                <div class="form-group"><label>Ano</label><input id="ano_moto" name="ano_moto"></div>
                <div class="form-group"><label>Quilometragem</label><input id="quilometragem" name="quilometragem"></div>
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
                <button class="btn-enviar"><i class="fas fa-paper-plane"></i> Enviar Manutenção</button>
            </div>
        </form>
    </div>
</div>

{{-- ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­ MODAL HISTÓRICO --}}
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
    function abrirModal(modelo, marca, dataAbertura) {
        document.getElementById("modalDetalhes").style.display = "flex";
        document.getElementById("modelo_moto").value = modelo;
        document.getElementById("fabricante_moto").value = marca;
        document.getElementById("data_abertura").value = dataAbertura;
        document.getElementById("situacao").value = "Pendente";
    }

    function fecharModal() {
        document.getElementById("modalDetalhes").style.display = "none";
    }

    function abrirModalHistorico() {
        document.getElementById("modalHistorico").style.display = "flex";

        const historico = [
            "15/05/2023 - Verificação de sistema de freio.",
            "16/05/2023 - Troca de pastilhas realizada.",
            "17/05/2023 - Cliente informado sobre conclusão."
        ];

        const lista = document.getElementById("listaHistorico");
        lista.innerHTML = "";
        historico.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item;
            lista.appendChild(li);
        });
    }

    function fecharModalHistorico() {
        document.getElementById("modalHistorico").style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', () => {
        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idServico = this.getAttribute('data-id');

                fetch(`/servico/${idServico}`)
                    .then(response => response.json())
                    .then(data => {
                        carregarPecasRegistradas(data); // 🔧 INSERIDO
                        document.getElementById("data_abertura").value = data.data_abertura;
                        document.getElementById("data_fechamento").value = data.data_fechamento ?? "";
                        document.getElementById("descricao_historico").value = data.descricao_manutencao ?? "";
                        document.getElementById("situacao").value = {
                            1: "Pendente",
                            2: "Em andamento",
                            3: "Concluído"
                        } [data.situacao] ?? "Pendente";

                        document.getElementById("fabricante_moto").value = data.moto.modelo.fabricante.nome;
                        document.getElementById("modelo_moto").value = data.moto.modelo.nome;

                        document.getElementById("placa_moto").value = data.moto.placa;
                        document.getElementById("ano_moto").value = data.moto.ano;
                        document.getElementById("quilometragem").value = data.quilometragem;
                        document.getElementById("descricao").value = "";

                        carregarPecas(data.moto.modelo.codigo);

                        // Atualiza a lista visual e a variável de controle
                        const ulMaoObra = document.getElementById("maoObraRegistrada");
                        const campoOculto = document.getElementById("mao_obra_lista");
                        ulMaoObra.innerHTML = "";
                        maoDeObraAdicionadas = [];

                        if (data.maos_obra && data.maos_obra.length > 0) {
                            let total = 0;

                            data.maos_obra.forEach(m => {
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
                                    // Remove visual
                                    li.remove();
                                    // Remove da variável
                                    maoDeObraAdicionadas = maoDeObraAdicionadas.filter(mao => mao.codigo !== m.codigo);
                                    // Atualiza o valor e campo oculto
                                    const totalAtualizado = maoDeObraAdicionadas.reduce((soma, item) => soma + parseFloat(item.valor), 0);
                                    document.getElementById("valor").value = "R$ " + totalAtualizado.toFixed(2).replace(".", ",");
                                    campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
                                };

                                li.appendChild(btnRemover);
                                ulMaoObra.appendChild(li);

                                total += parseFloat(m.valor);
                            });


                            campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
                            document.getElementById("valor").value = "R$ " + total.toFixed(2).replace(".", ",");
                        } else {
                            const li = document.createElement("li");
                            li.innerHTML = "<em>Nenhuma mão de obra registrada.</em>";
                            ulMaoObra.appendChild(li);
                            campoOculto.value = "[]";
                            document.getElementById("valor").value = "R$ 0,00";
                        }

                        // Atualiza a rota do formulário
                        document.getElementById("formDetalhes").action = `/manutencao/${data.codigo}/descricao`;

                        // Exibe o modal
                        document.getElementById("modalDetalhes").style.display = "flex";
                    })
                    .catch(error => {
                        console.error("Erro ao carregar detalhes do serviço:", error);
                        alert("Erro ao carregar dados da manutenção.");
                    });
            });
        });
    });


    const historicoBtns = document.querySelectorAll('.btn-historico');
    historicoBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            abrirModalHistorico();
        });
    });



    // Envia a lista atualizada ao submeter o formulário
    function enviarFormulario() {
        const maoObraLista = document.getElementById("mao_obra_lista").value;
        console.log("Enviando lista:", maoObraLista); // para teste
        return true; // permite envio normal
    }

    function prepararEnvioDescricao() {
        const descricaoInput = document.getElementById("descricao");
        const historicoTextarea = document.getElementById("descricao_historico");
        const pecaLista = document.getElementById("peca_lista");
        const maoObraLista = document.getElementById("mao_obra_lista");

        // Atualiza os campos ocultos com os JSONs corretos
        pecaLista.value = JSON.stringify(pecasAdicionadas);
        maoObraLista.value = JSON.stringify(maoDeObraAdicionadas);

        console.log("🔧 JSON enviado - Peças:", pecaLista.value);
        console.log("🔧 JSON enviado - Mão de obra:", maoObraLista.value);

        // Gera o histórico de descrição
        const novaDescricao = descricaoInput.value.trim();
        if (!novaDescricao) return true;

        const dataAtual = new Date();
        const dataFormatada = dataAtual.toLocaleString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const novaEntrada = `${dataFormatada} - ${novaDescricao}`;
        const historicoAtual = historicoTextarea.value.trim();
        const novoHistorico = historicoAtual ? `${historicoAtual}\n${novaEntrada}` : novaEntrada;

        historicoTextarea.value = novoHistorico;

        // Cria input hidden com histórico final
        const campoHistorico = document.createElement("input");
        campoHistorico.type = "hidden";
        campoHistorico.name = "descricao_historico";
        campoHistorico.value = novoHistorico;
        document.getElementById("formDetalhes").appendChild(campoHistorico);

        return true; // Prossegue com envio
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

    let pecasDisponiveis = [];
    let pecasAdicionadas = [];

    function carregarPecas(codModelo) {
        const select = document.getElementById("peca");
        fetch(`/api/pecas/${codModelo}`)
            .then(res => res.json())
            .then(data => {
                pecasDisponiveis = data;
                select.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.codigo;
                    option.textContent = `${item.nome} - R$ ${parseFloat(item.preco).toFixed(2).replace(".", ",")}`;
                    option.dataset.nome = item.nome;
                    option.dataset.preco = item.preco;
                    select.appendChild(option);
                });
            });
    }

    document.getElementById('btnAdicionarPeca').addEventListener('click', () => {
        const select = document.getElementById('peca');
        const codigo = parseInt(select.value, 10);
        if (!codigo) return;

        const peca = pecasDisponiveis.find(p => p.codigo === codigo);
        if (!peca) {
            alert('Peça inválida.');
            return;
        }

        const existente = pecasAdicionadas.find(p => p.codigo === codigo);
        if (existente) {
            existente.quantidade += 1;
        } else {
            pecasAdicionadas.push({
                codigo: peca.codigo,
                nome: peca.nome,
                preco: parseFloat(peca.preco),
                quantidade: 1
            });
        }

        atualizarListaPecas();
    });


    function atualizarListaPecas() {
        const ul = document.getElementById("listaPecas");
        ul.innerHTML = "";

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
                atualizarListaPecas();
            };

            li.appendChild(btnRemover);
            ul.appendChild(li);
        });

        atualizarValorTotal();
        document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
        li.textContent = `${peca.nome} - R$ ${(peca.preco * peca.quantidade).toFixed(2).replace('.', ',')} (x${peca.quantidade})`;

        const btnRemover = document.createElement("button");
        btnRemover.textContent = "✖";
        btnRemover.style.cssText = "margin-left:10px;background:none;border:none;color:red;cursor:pointer";
        btnRemover.onclick = () => {
            pecasAdicionadas = pecasAdicionadas.filter(p => p.codigo !== peca.codigo);
            atualizarListaPecas();
        };

        li.appendChild(btnRemover);
        ul.appendChild(li);
    };

    atualizarValorTotal();
    document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);


    function atualizarValorTotal() {
        const totalMao = maoDeObraAdicionadas.reduce((soma, item) => soma + parseFloat(item.valor), 0);
        const totalPeca = pecasAdicionadas.reduce((soma, item) => soma + parseFloat(item.preco) * item.quantidade, 0);
        const totalGeral = totalMao + totalPeca;

        document.getElementById("valor").value = "R$ " + totalGeral.toFixed(2).replace(".", ",");
    }

    document.getElementById('btnAdicionarPeca').addEventListener('click', () => {
        const select = document.getElementById('peca');
        const codigo = parseInt(select.value, 10);
        if (!codigo) return;

        const peca = pecasDisponiveis.find(p => p.codigo === codigo);
        if (!peca || pecasAdicionadas.some(p => p.codigo === codigo)) {
            alert('Peça já adicionada ou inválida.');
            return;
        }

        pecasAdicionadas.push(peca);

        const li = document.createElement('li');
        li.textContent = `${peca.nome} - R$ ${(+peca.preco).toFixed(2).replace('.', ',')}`;

        const btnX = document.createElement('button');
        btnX.textContent = '✖';
        btnX.style.cssText = 'margin-left:10px;background:none;border:none;color:red;cursor:pointer';
        btnX.onclick = () => {
            li.remove();
            pecasAdicionadas = pecasAdicionadas.filter(p => p.codigo !== peca.codigo);
            atualizarValorTotal();
            document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
        };

        li.appendChild(btnX);
        document.getElementById("listaPecas").appendChild(li);

        atualizarValorTotal();
        document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
    });

    
</script>

<script>
    let maoDeObraDisponiveis = [];
    let maoDeObraAdicionadas = [];

    function atualizarValorTotal() {
        const totalMao = maoDeObraAdicionadas.reduce((soma, item) => soma + parseFloat(item.valor), 0);
        const totalPeca = pecasAdicionadas.reduce((soma, item) => soma + parseFloat(item.preco), 0);
        const totalGeral = totalMao + totalPeca;

        document.getElementById("valor").value = "R$ " + totalGeral.toFixed(2).replace(".", ",");
    }


    function carregarMaoDeObra() {
        const select = document.getElementById("mao_obra");
        fetch('/api/mao-de-obra')
            .then(res => res.json())
            .then(data => {
                maoDeObraDisponiveis = data;
                select.innerHTML = ''; // limpa o select
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




    document.addEventListener('DOMContentLoaded', () => {
        /* popula o <select> com as MOs cadastradas */
        carregarMaoDeObra();

        /* ------------ BOTÃO “ADICIONAR” --------------- */
        const btnAdicionar = document.getElementById('btnAdicionarMaoObra');
        const select = document.getElementById('mao_obra');
        const lista = document.getElementById('listaMaoObra');
        const campoOculto = document.getElementById('mao_obra_lista');

        btnAdicionar.addEventListener('click', () => {
            const codigo = parseInt(select.value, 10);
            if (!codigo) return; // nada escolhido

            const mao = maoDeObraDisponiveis.find(m => m.codigo === codigo);
            if (!mao) return;

            if (maoDeObraAdicionadas.some(m => m.codigo === codigo)) { // evita duplicidade
                alert('Essa mão de obra já foi adicionada.');
                return;
            }

            maoDeObraAdicionadas.push(mao);

            /* item visual na lista */
            const li = document.createElement('li');
            li.textContent = `${mao.nome} - R$ ${(+mao.valor).toFixed(2).replace('.', ',')}`;

            const btnX = document.createElement('button');
            btnX.textContent = '✖';
            btnX.style.cssText =
                'margin-left:10px;background:none;border:none;color:red;cursor:pointer';
            btnX.onclick = () => {
                li.remove();
                maoDeObraAdicionadas =
                    maoDeObraAdicionadas.filter(m => m.codigo !== mao.codigo);
                atualizarValorTotal();
                campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
            };

            li.appendChild(btnX);
            lista.appendChild(li);

            atualizarValorTotal();
            campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
        });
        /* ---------------------------------------------- */

        /* ------------ ABRIR MODAL DETALHES ------------ */
        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const idServico = btn.dataset.id;

                fetch(`/servico/${idServico}`)
                    .then(r => r.json())
                    .then(data => {
                        carregarPecasRegistradas(data); // 🔧 INSERIDO
                        /* suas atribuições originais … */
                        /* ... (não alterei nada aqui) ... */
                    })
                    .catch(() => alert('Erro ao carregar dados da manutenção.'));
            });
        });
    });

    
</script>

<script>
    function mapearSituacao(situacao) {
        switch (situacao) {
            case 1:
                return 'Pendente';
            case 2:
                return 'Em andamento';
            case 3:
                return 'Concluído';
            default:
                return 'Pendente';
        }
    }

    function preencherModalComDados(servico) {
        document.querySelector('#descricao_historico').value = servico.descricao_manutencao || '';
        document.querySelector('#situacao').value = mapearSituacao(servico.situacao);
        document.querySelector('#data_fechamento').value = servico.data_fechamento || '';

        let total = 0;
        const lista = [];

        const listaElement = document.getElementById('mao_obra_adicionada');
        listaElement.innerHTML = '';

        servico.maos_obra.forEach(mao => {
            const item = {
                codigo: mao.codigo,
                nome: mao.nome,
                valor: parseFloat(mao.valor)
            };

            lista.push(item);
            total += item.valor;

            const li = document.createElement('li');
            li.textContent = `${item.nome} - R$ ${item.valor.toFixed(2)}`;
            listaElement.appendChild(li);
        });

        document.querySelector('#valor_total').value = `R$ ${total.toFixed(2)}`;
        document.querySelector('#mao_obra_lista').value = JSON.stringify(lista);
    }

    function carregarPecasRegistradas(data) {
    const ulPecas = document.getElementById("pecasRegistradas");
    ulPecas.innerHTML = "";
    pecasAdicionadas = [];

    if (data.pecas && data.pecas.length > 0) {
        data.pecas.forEach((p, index) => {
            const item = {
                codigo: p.codigo,
                nome: p.nome,
                preco: parseFloat(p.preco),
                quantidade: p.pivot?.quantidade || 1
            };
            pecasAdicionadas.push(item);

            const li = document.createElement("li");
            li.textContent = `${item.nome} - R$ ${(item.preco * item.quantidade).toFixed(2).replace(".", ",")} (x${item.quantidade})`;

            const btnRemover = document.createElement("button");
            btnRemover.textContent = "✖";
            btnRemover.style.cssText = "margin-left:10px;background:none;border:none;color:red;cursor:pointer";
            btnRemover.onclick = () => {
                if (item.quantidade > 1) {
                    item.quantidade -= 1;
                } else {
                    pecasAdicionadas.splice(index, 1);
                }
                atualizarValorTotal();
                document.getElementById("peca_lista").value = JSON.stringify(pecasAdicionadas);
                carregarPecasRegistradas({
                    pecas: pecasAdicionadas.map(p => ({
                        codigo: p.codigo,
                        nome: p.nome,
                        preco: p.preco,
                        pivot: { quantidade: p.quantidade }
                    }))
                });
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


@endsection


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
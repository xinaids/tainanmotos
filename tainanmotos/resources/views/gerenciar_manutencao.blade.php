@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Gerenciar Manutenções</h2>
    <p>Acompanhe e administre as manutenções em aberto no sistema.</p>

    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Buscar...">
        <select id="search-type" name="search-type" style="appearance: none; background-image: none;">
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="nome">Nome do Cliente</option>
        </select>
    </div>

    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Nome do Cliente</th>
                <th>Data de Abertura</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicos as $servico)
            <tr data-modelo="{{ $servico->moto->modelo->nome ?? '' }}"
                data-marca="{{ $servico->moto->modelo->fabricante->nome ?? '' }}"
                data-data_abertura="{{ \Carbon\Carbon::parse($servico->data_abertura)->format('Y-m-d') }}">
                <td>{{ $servico->moto->modelo->nome ?? '-' }}</td>
                <td>{{ $servico->moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $servico->moto->usuario->nome ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d/m/Y') }}</td>
                <td>
                    <a href="#" class="btn-visualizar" data-id="{{ $servico->codigo }}"><i class="fas fa-search"></i> Ver Detalhes</a>
                    <a href="#" class="btn-historico"><i class="fas fa-history"></i> Histórico</a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
</div>

<!-- Modal Detalhes -->
<div id="modalDetalhes" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3>Detalhes da Manutenção</h3>
        <form class="modal-form" id="formDetalhes" method="POST" onsubmit="return prepararEnvioDescricao();">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="data_abertura">Data Abertura</label>
                    <input type="date" id="data_abertura" name="data_abertura" value="2023-05-15">
                </div>
                <div class="form-group">
                    <label for="data_fechamento">Data Fechamento</label>
                    <input type="date" id="data_fechamento" name="data_fechamento">
                </div>
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select id="situacao" name="situacao">
                        <option value="Pendente" selected>Pendente</option>
                        <option value="Em andamento">Em andamento</option>
                        <option value="Concluído">Concluído</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fabricante_moto">Fabricante</label>
                    <input type="text" id="fabricante_moto" name="fabricante_moto" value="Yamaha">
                </div>
                <div class="form-group">
                    <label for="modelo_moto">Modelo</label>
                    <input type="text" id="modelo_moto" name="modelo_moto" value="XTZ 250 Lander">
                </div>
                <div class="form-group">
                    <label for="placa_moto">Placa</label>
                    <input type="text" id="placa_moto" name="placa_moto" value="IWG-2171">
                </div>
                <div class="form-group">
                    <label for="ano_moto">Ano</label>
                    <input type="text" id="ano_moto" name="ano_moto" value="2015">
                </div>
                <div class="form-group">
                    <label for="quilometragem">Quilometragem</label>
                    <input type="text" id="quilometragem" name="quilometragem" value="80834">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="valor">Valor</label>
                    <input type="text" id="valor" name="valor" value="R$ 0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="mao_obra">Atribuir Mão de Obra</label>
                    <select id="mao_obra" name="mao_obra"></select>

                    <div style="margin-top: 8px; display: flex; gap: 8px;">
                        <button type="button" class="btn-plus" id="btnAdicionarMaoObra">Adicionar</button>
                    </div>
                    <ul id="listaMaoObra" style="margin-top: 10px; padding-left: 20px; list-style-type: disc;"></ul>
                    <input type="hidden" name="mao_obra_lista" id="mao_obra_lista">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4"></textarea>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="descricao_historico">Histórico de Descrições</label>
                    <textarea id="descricao_historico" rows="6" readonly style="background-color: #f5f5f5;"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label>Mão de Obra Registrada</label>
                    <ul id="maoObraRegistrada" style="background-color: #f5f5f5; padding: 10px; border-radius: 8px; list-style-type: disc;">
                        <li><em>Nenhuma mão de obra registrada.</em></li>
                    </ul>
                </div>
            </div>
            <div class="form-row" style="justify-content: flex-end;">
                <button type="submit" class="btn-enviar">
                    <i class="fas fa-paper-plane"></i> Enviar Manutenção
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Histórico -->
<div id="modalHistorico" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModalHistorico()">&times;</span>
        <h3>Histórico de Descrições</h3>
        <div id="historicoDescricao" style="max-height: 300px; overflow-y: auto; padding: 10px; background: #f9f9f9; border: 1px solid #ccc; border-radius: 8px;">
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
                        document.getElementById("valor").value = "R$ " + parseFloat(data.valor).toFixed(2);
                        document.getElementById("descricao").value = data.descricao_manutencao ?? "";

                        // Atualiza a lista de mão de obra registrada
                        const ulMaoObra = document.getElementById("maoObraRegistrada");
                        ulMaoObra.innerHTML = "";

                        if (data.maos_obra && data.maos_obra.length > 0) {
                            data.maos_obra.forEach(m => {
                                const li = document.createElement("li");
                                li.textContent = `${m.nome} — R$ ${parseFloat(m.valor).toFixed(2).replace(".", ",")}`;
                                ulMaoObra.appendChild(li);
                            });
                        } else {
                            const li = document.createElement("li");
                            li.innerHTML = "<em>Nenhuma mão de obra registrada.</em>";
                            ulMaoObra.appendChild(li);
                        }

                        document.getElementById("formDetalhes").action = `/manutencao/${data.codigo}/descricao`;

                        document.getElementById("modalDetalhes").style.display = "flex";
                    })
                    .catch(error => {
                        console.error("Erro ao carregar detalhes do serviço:", error);
                        alert("Erro ao carregar dados da manutenção.");
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
    });

    document.addEventListener("DOMContentLoaded", () => {
        // Código já existente...

        const btnAdicionar = document.getElementById("btnAdicionarMaoObra");
        const selectMaoObra = document.getElementById("mao_obra");
        const listaMaoObra = document.getElementById("listaMaoObra");
        const campoOculto = document.getElementById("mao_obra_lista");

        btnAdicionar.addEventListener("click", () => {
            const valorSelecionado = selectMaoObra.value;
            if (!valorSelecionado) return;

            // Verifica se já foi adicionado
            const itensExistentes = Array.from(listaMaoObra.children).map(li => li.dataset.valor);
            if (itensExistentes.includes(valorSelecionado)) return;

            const li = document.createElement("li");
            li.textContent = valorSelecionado;
            li.dataset.valor = valorSelecionado;

            const btnRemover = document.createElement("button");
            btnRemover.textContent = "Remover";
            btnRemover.style.marginLeft = "10px";
            btnRemover.style.backgroundColor = "#dc3545";
            btnRemover.style.color = "#fff";
            btnRemover.style.border = "none";
            btnRemover.style.borderRadius = "4px";
            btnRemover.style.padding = "2px 8px";
            btnRemover.style.cursor = "pointer";

            btnRemover.addEventListener("click", () => {
                listaMaoObra.removeChild(li);
                atualizarCampoOculto();
            });

            li.appendChild(btnRemover);
            listaMaoObra.appendChild(li);
            atualizarCampoOculto();
        });

        function atualizarCampoOculto() {
            const valores = Array.from(listaMaoObra.children).map(li => li.dataset.valor);
            campoOculto.value = JSON.stringify(valores);
        }
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

        const novaDescricao = descricaoInput.value.trim();
        if (!novaDescricao) return true; // Não faz nada se vazio

        const dataAtual = new Date();
        const dataFormatada = dataAtual.toLocaleDateString('pt-BR');
        const novaEntrada = `${dataFormatada} - ${novaDescricao}`;

        // Adiciona nova entrada ao histórico existente
        const historicoAtual = historicoTextarea.value.trim();
        const novoHistorico = historicoAtual ? `${historicoAtual}\n${novaEntrada}` : novaEntrada;

        historicoTextarea.value = novoHistorico;

        // Clona o conteúdo para enviar com o form
        const campoClone = document.createElement("input");
        campoClone.type = "hidden";
        campoClone.name = "descricao";
        campoClone.value = novoHistorico;
        document.getElementById("formDetalhes").appendChild(campoClone);

        return true; // prossegue com o envio
    }
</script>

<script>
    let maoDeObraDisponiveis = [];
    let maoDeObraAdicionadas = [];

    function atualizarValorTotal() {
        const total = maoDeObraAdicionadas.reduce((soma, item) => soma + parseFloat(item.valor), 0);
        document.getElementById("valor").value = "R$ " + total.toFixed(2).replace(".", ",");
    }

    function carregarMaoDeObra() {
        fetch('/mao-obra/listar')
            .then(res => res.json())
            .then(data => {
                maoDeObraDisponiveis = data;

                const select = document.getElementById("mao_obra");
                select.innerHTML = ''; // limpar

                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.nome;
                    option.textContent = `${item.nome} - R$ ${parseFloat(item.valor).toFixed(2).replace(".", ",")}`;
                    option.dataset.valor = item.valor;
                    select.appendChild(option);
                });
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarMaoDeObra();

        const btnAdicionar = document.getElementById("btnAdicionarMaoObra");
        const select = document.getElementById("mao_obra");
        const lista = document.getElementById("listaMaoObra");
        const campoOculto = document.getElementById("mao_obra_lista");

        btnAdicionar.addEventListener("click", () => {
            const nomeSelecionado = select.value;
            const jaAdicionada = maoDeObraAdicionadas.some(item => item.nome === nomeSelecionado);
            if (jaAdicionada) return;

            const mao = maoDeObraDisponiveis.find(m => m.nome === nomeSelecionado);
            if (!mao) return;

            maoDeObraAdicionadas.push(mao);

            const li = document.createElement("li");
            li.textContent = `${mao.nome} - R$ ${parseFloat(mao.valor).toFixed(2).replace(".", ",")}`;
            li.dataset.nome = mao.nome;

            const btnRemover = document.createElement("button");
            btnRemover.textContent = "Remover";
            btnRemover.style.marginLeft = "10px";
            btnRemover.style.backgroundColor = "#dc3545";
            btnRemover.style.color = "#fff";
            btnRemover.style.border = "none";
            btnRemover.style.borderRadius = "4px";
            btnRemover.style.padding = "2px 8px";
            btnRemover.style.cursor = "pointer";

            btnRemover.addEventListener("click", () => {
                maoDeObraAdicionadas = maoDeObraAdicionadas.filter(m => m.nome !== mao.nome);
                lista.removeChild(li);
                atualizarValorTotal();
                campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
            });

            li.appendChild(btnRemover);
            lista.appendChild(li);
            campoOculto.value = JSON.stringify(maoDeObraAdicionadas);
            atualizarValorTotal();
        });
    });
</script>





@endsection




<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .gerenciar-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .gerenciar-container h2 {
        font-size: 26px;
        margin-bottom: 5px;
    }

    .gerenciar-container p {
        font-size: 15px;
        color: #555;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .search-container {
        margin: 20px 0;
        display: flex;
        gap: 10px;
    }

    .search-container input,
    .search-container select {
        padding: 10px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .search-container input:focus,
    .search-container select:focus {
        outline: none;
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    }

    /* --- Tabela --- */
    .manutencao-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .manutencao-table th,
    .manutencao-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        text-align: left;
        font-size: 14px;
    }

    .manutencao-table th {
        background-color: #f0f2f5;
        font-weight: bold;
    }

    .manutencao-table tr {
        transition: background-color 0.3s ease;
    }

    .manutencao-table tr:hover {
        background-color: #f9f9f9;
    }

    /* --- Botões --- */
    .btn-visualizar,
    .btn-voltar,
    .btn-concluir {
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-visualizar {
        background-color: #ffe633;
        color: #333;
        border: none;
    }

    .btn-visualizar:hover {
        background-color: #ffdd00;
        transform: translateY(-2px);
    }

    .btn-concluir {
        background-color: #4caf50;
        color: white;
        border: none;
    }

    .btn-concluir:hover {
        background-color: #43a047;
        transform: translateY(-2px);
    }

    .btn-voltar {
        margin-top: 20px;
        background-color: #2196f3;
        color: white;
        border: none;
    }

    .btn-voltar:hover {
        background-color: #1976d2;
        transform: translateY(-2px);
    }

    .btn-visualizar i,
    .btn-voltar i,
    .btn-concluir i {
        margin-right: 5px;
    }

    /* --- Modal --- */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 900px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: fadeIn 0.3s ease-in-out;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #555;
    }

    /* --- Formulário Modal --- */
    .modal-form .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .modal-form .form-group {
        flex: 1;
        min-width: 150px;
    }

    .modal-form label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .modal-form input,
    .modal-form textarea,
    .modal-form select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        box-sizing: border-box;
        background-color: white;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        /* background-image: url("data:image/svg+xml,%3Csvg fill='gray' height='18' viewBox='0 0 24 24' width='18' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3Cpath d='M0 0h24v24H0z' fill='none'/%3E%3C/svg%3E");
    */
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px 16px;
        transition: border-color 0.3s;
    }

    .modal-form select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
        outline: none;
    }

    .modal-form textarea:focus,
    .modal-form select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
        outline: none;
    }

    .modal-form select {
        background-color: white;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    /* --- Botão + --- */
    .btn-plus {
        padding: 10px 12px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-plus:hover {
        background-color: #115293;
    }

    .btn-enviar {
        padding: 12px 20px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-enviar:hover {
        background-color: #115293;
        transform: translateY(-2px);
    }

    .btn-historico {
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        background-color: #6c757d;
        color: white;
        margin-left: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-historico:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
</style>
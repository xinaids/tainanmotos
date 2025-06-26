@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Visualizar Manutenções</h2>
    <p>Consulte abaixo as manutenções registradas no sistema.</p>

    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Buscar...">
        <select id="search-type" name="search-type">
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="nome">Nome do Cliente</option>
            <option value="status">Status</option>
        </select>
    </div>

    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Nome do Cliente</th>
                <th>Data de Abertura</th>
                <th>Status</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicos as $servico)
            <tr data-id="{{ $servico->codigo }}">
                <td>{{ $servico->moto->modelo->nome ?? '-' }}</td>
                <td>{{ $servico->moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $servico->moto->usuario->nome ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d/m/Y') }}</td>
                {{-- Célula para o Status, usando diretivas Blade para o switch --}}
                <td>
                    @switch($servico->situacao)
                        @case(1)
                            Pendente
                            @break
                        @case(2)
                            Em andamento
                            @break
                        @case(3)
                            Concluído
                            @break
                        @default
                            -
                    @endswitch
                </td>
                <td>
                    <a href="#" class="btn-visualizar" data-id="{{ $servico->codigo }}">
                        <i class="fas fa-search"></i> Ver Detalhes
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
</div>

<div id="modalDetalhes" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3>Detalhes da Manutenção</h3>
        <form class="modal-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="data_abertura">Data Abertura</label>
                    <input type="date" id="data_abertura" name="data_abertura" readonly>
                </div>
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <input type="text" id="situacao" name="situacao" readonly>
                </div>
                <div class="form-group">
                    <label for="valor">Valor Total</label>
                    <input type="text" id="valor" name="valor" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fabricante_moto">Fabricante</label>
                    <input type="text" id="fabricante_moto" name="fabricante_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="modelo_moto">Modelo</label>
                    <input type="text" id="modelo_moto" name="modelo_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="placa_moto">Placa</label>
                    <input type="text" id="placa_moto" name="placa_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="ano_moto">Ano</label>
                    <input type="text" id="ano_moto" name="ano_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="quilometragem">Quilometragem</label>
                    <input type="text" id="quilometragem" name="quilometragem" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="descricao">Descrição da Manutenção</label>
                    <textarea id="descricao" name="descricao" rows="6" readonly style="background:#f5f5f5;"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="mao_obra_adicionada">Mão de Obra Registrada</label>
                    <ul id="mao_obra_adicionada" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="pecas_adicionadas">Peças Registradas</label>
                    <ul id="pecas_adicionadas" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
            </div>

            <div class="form-row" style="justify-content:flex-end;">
                <button type="button" class="btn-voltar" onclick="fecharModal()">Fechar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Função para fechar o modal
    function fecharModal() {
        document.getElementById("modalDetalhes").style.display = "none";
    }

    // Adiciona o event listener para os botões "Ver Detalhes"
    document.addEventListener('DOMContentLoaded', () => {
        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idServico = this.dataset.id; // Pega o ID do serviço do atributo data-id

                // Define o conteúdo inicial para "Carregando..."
                document.getElementById("mao_obra_adicionada").innerHTML = '<li><em>Carregando...</em></li>';
                document.getElementById("pecas_adicionadas").innerHTML = '<li><em>Carregando...</em></li>';

                fetch(`/servico/${idServico}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok ' + res.statusText);
                        }
                        return res.json();
                    })
                    .then(data => {
                        // Preenche os campos de texto do modal
                        document.getElementById("data_abertura").value = data.data_abertura;
                        document.getElementById("situacao").value = {
                            1: "Pendente",
                            2: "Em andamento",
                            3: "Concluído"
                        }[data.situacao] ?? "-"; // Mantido para 'situacao' dentro do modal

                        document.getElementById("fabricante_moto").value = data.moto.modelo.fabricante.nome ?? '-';
                        document.getElementById("modelo_moto").value = data.moto.modelo.nome ?? '-';
                        document.getElementById("placa_moto").value = data.moto.placa ?? '-';
                        document.getElementById("ano_moto").value = data.moto.ano ?? '-';
                        document.getElementById("quilometragem").value = data.quilometragem ?? '-';
                        document.getElementById("descricao").value = data.descricao_manutencao ?? data.descricao ?? ''; // Prioriza descricao_manutencao, senão descricao
                        document.getElementById("valor").value = `R$ ${parseFloat(data.valor).toFixed(2).replace('.', ',')}`;

                        // Preenche a lista de Mão de Obra
                        const ulMaoObra = document.getElementById("mao_obra_adicionada");
                        ulMaoObra.innerHTML = ''; // Limpa o "Carregando..."
                        if (data.maos_obra && data.maos_obra.length > 0) {
                            data.maos_obra.forEach(item => {
                                const li = document.createElement('li');
                                li.textContent = `${item.nome} - R$ ${parseFloat(item.valor).toFixed(2).replace('.', ',')}`;
                                ulMaoObra.appendChild(li);
                            });
                        } else {
                            ulMaoObra.innerHTML = '<li><em>Nenhuma mão de obra registrada.</em></li>';
                        }

                        // Preenche a lista de Peças
                        const ulPecas = document.getElementById("pecas_adicionadas");
                        ulPecas.innerHTML = ''; // Limpa o "Carregando..."
                        if (data.pecas && data.pecas.length > 0) {
                            data.pecas.forEach(item => {
                                const li = document.createElement('li');
                                // Acessa a quantidade através do pivot se existir, senão assume 1
                                const quantidade = item.pivot ? (item.pivot.quantidade || 1) : 1;
                                li.textContent = `${item.nome} - R$ ${(parseFloat(item.preco) * quantidade).toFixed(2).replace('.', ',')} (x${quantidade})`;
                                ulPecas.appendChild(li);
                            });
                        } else {
                            ulPecas.innerHTML = '<li><em>Nenhuma peça registrada.</em></li>';
                        }

                        // Exibe o modal após preencher todos os dados
                        document.getElementById("modalDetalhes").style.display = "flex";
                    })
                    .catch(err => {
                        console.error("Erro ao buscar detalhes da manutenção:", err);
                        alert("Não foi possível carregar os detalhes da manutenção.");
                        // Em caso de erro, define as mensagens de erro nas listas
                        document.getElementById("mao_obra_adicionada").innerHTML = '<li><em>Erro ao carregar mão de obra.</em></li>';
                        document.getElementById("pecas_adicionadas").innerHTML = '<li><em>Erro ao carregar peças.</em></li>';
                    });
            });
        });
    });

    // Funções de filtro de busca (mantidas, mas não relacionadas ao problema de carregamento do modal)
    document.getElementById('search').addEventListener('keyup', filterTable);
    document.getElementById('search-type').addEventListener('change', filterTable);

    function filterTable() {
        const searchText = document.getElementById('search').value.toLowerCase();
        const searchType = document.getElementById('search-type').value;
        const rows = document.querySelectorAll('.manutencao-table tbody tr');

        rows.forEach(row => {
            let cellContent = '';
            // Ajuste os índices das colunas para corresponder à nova estrutura da tabela
            if (searchType === 'modelo') {
                cellContent = row.children[0].textContent.toLowerCase();
            } else if (searchType === 'marca') {
                cellContent = row.children[1].textContent.toLowerCase();
            } else if (searchType === 'nome') {
                cellContent = row.children[2].textContent.toLowerCase();
            } else if (searchType === 'status') { // Adicionado para buscar por status na tabela
                cellContent = row.children[4].textContent.toLowerCase(); // Índice 4 para a nova coluna 'Status'
            }

            if (cellContent.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<style>
    /* Estilos CSS (mantidos os mesmos do seu arquivo original) */
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
        max-width: 1000px !important;
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

    /* ---------- LISTAS DE MÃO DE OBRA E PEÇAS ---------- */
    #mao_obra_adicionada li,
    #pecas_adicionadas li {
        padding: 5px 0;
        border-bottom: 1px dashed #eee;
    }
    #mao_obra_adicionada li:last-child,
    #pecas_adicionadas li:last-child {
        border-bottom: none;
    }
</style>
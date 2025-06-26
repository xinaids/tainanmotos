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
            <tr data-id="{{ $servico->codigo }}">
                <td>{{ $servico->moto->modelo->nome ?? '-' }}</td>
                <td>{{ $servico->moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $servico->moto->usuario->nome ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d/m/Y') }}</td>
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

<!-- Modal Detalhes -->
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
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" readonly></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="valor">Valor Total</label>
                    <input type="text" id="valor" name="valor" readonly>
                </div>
            </div>

            <!-- Lista de Mão de Obra Adicionada -->
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="mao_obra_adicionada">Mão de Obra Adicionada</label>
                    <ul id="mao_obra_adicionada" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
            </div>

            <!-- Lista de Peças Adicionadas -->
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="pecas_adicionadas">Peças Adicionadas</label>
                    <ul id="pecas_adicionadas" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function fecharModal() {
        document.getElementById("modalDetalhes").style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', () => {
        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idServico = this.dataset.id;

                fetch(`/servico/${idServico}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById("data_abertura").value = data.data_abertura;
                        document.getElementById("situacao").value = {
                            1: "Pendente",
                            2: "Em andamento",
                            3: "Concluído"
                        } [data.situacao] ?? "-";
                        document.getElementById("fabricante_moto").value = data.moto.modelo.fabricante.nome;
                        document.getElementById("modelo_moto").value = data.moto.modelo.nome;
                        document.getElementById("placa_moto").value = data.moto.placa;
                        document.getElementById("ano_moto").value = data.moto.ano;
                        document.getElementById("quilometragem").value = data.quilometragem;
                        document.getElementById("descricao").value = data.descricao_manutencao ?? '';
                        document.getElementById("valor").value = "R$ " + parseFloat(data.valor).toFixed(2).replace(".", ",");

                        document.getElementById("modalDetalhes").style.display = "flex";
                    })
                    .catch(err => {
                        alert("Erro ao buscar detalhes da manutenção.");
                        console.error(err);
                    });
            });
        });
    });
</script>

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

    .manutencao-table tr:hover {
        background-color: #f9f9f9;
    }

    .btn-visualizar,
    .btn-voltar {
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
    .btn-voltar i {
        margin-right: 5px;
    }

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
    }

    /* REMOÇÃO DAS SETAS E DROPDOWN NATIVO */
    .modal-form input[type="date"],
    .modal-form input[type="number"],
    .modal-form select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: none !important;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .modal-form select:focus,
    .modal-form textarea:focus,
    .modal-form input:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
        outline: none;
    }
</style>

<script>
    function carregarDetalhesServicoVisualizar(servicoId) {
        fetch(`/servico/${servicoId}`)
            .then(res => res.json())
            .then(data => {
                const listaPecas = document.getElementById("pecasAdicionadasVisualizar");
                const listaMaos = document.getElementById("maosObraAdicionadasVisualizar");

                listaPecas.innerHTML = '';
                if (data.pecas && data.pecas.length > 0) {
                    data.pecas.forEach(p => {
                        const li = document.createElement("li");
                        li.textContent = `${p.nome} - R$ ${parseFloat(p.preco).toFixed(2).replace('.', ',')}`;
                        listaPecas.appendChild(li);
                    });
                } else {
                    listaPecas.innerHTML = '<li><em>Nenhuma peça registrada.</em></li>';
                }

                listaMaos.innerHTML = '';
                if (data.maodeobra && data.maodeobra.length > 0) {
                    data.maodeobra.forEach(m => {
                        const li = document.createElement("li");
                        li.textContent = `${m.nome} - R$ ${parseFloat(m.preco).toFixed(2).replace('.', ',')}`;
                        listaMaos.appendChild(li);
                    });
                } else {
                    listaMaos.innerHTML = '<li><em>Nenhuma mão de obra registrada.</em></li>';
                }
            });
    }

    function carregarDetalhesServicoVisualizar(id) {
        fetch(`/servico/${id}`)
            .then(res => res.json())
            .then(data => {
                // Campos existentes
                document.getElementById("data_abertura").value = data.data_abertura;
                document.getElementById("situacao").value = data.situacao_label;
                document.getElementById("fabricante_moto").value = data.fabricante;
                document.getElementById("modelo_moto").value = data.modelo;
                document.getElementById("placa_moto").value = data.placa;
                document.getElementById("ano_moto").value = data.ano;
                document.getElementById("quilometragem").value = data.quilometragem;
                document.getElementById("descricao").value = data.descricao_manutencao || '';
                document.getElementById("valor").value = `R$ ${parseFloat(data.valor_total).toFixed(2).replace('.', ',')}`;

                // Mão de obra
                const ulMaoObra = document.getElementById("mao_obra_adicionada");
                ulMaoObra.innerHTML = '';
                if (data.mao_obra.length === 0) {
                    ulMaoObra.innerHTML = '<li><em>Nenhuma mão de obra registrada.</em></li>';
                } else {
                    data.mao_obra.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = `${item.nome} - R$ ${parseFloat(item.preco).toFixed(2).replace('.', ',')}`;
                        ulMaoObra.appendChild(li);
                    });
                }

                // Peças
                const ulPecas = document.getElementById("pecas_adicionadas");
                ulPecas.innerHTML = '';
                if (data.pecas.length === 0) {
                    ulPecas.innerHTML = '<li><em>Nenhuma peça registrada.</em></li>';
                } else {
                    data.pecas.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = `${item.nome} - R$ ${parseFloat(item.preco).toFixed(2).replace('.', ',')}`;
                        ulPecas.appendChild(li);
                    });
                }

                document.getElementById("modalDetalhes").style.display = "block";
            });
    }
</script>
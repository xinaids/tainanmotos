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
            <tr data-modelo="XTZ 250 Lander" data-marca="Yamaha" data-data_abertura="2023-05-15">
                <td>XTZ 250 Lander</td>
                <td>Yamaha</td>
                <td>João Silva</td>
                <td>15/05/2023</td>
                <td>
                    <a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a>
                    <a href="#" class="btn-historico"><i class="fas fa-history"></i> Histórico</a>
                </td>
            </tr>
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
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" id="valor" name="valor" value="R$ 0">
                </div>
                <div class="form-group">
                    <label for="mao_obra">Atribuir Mão de Obra</label>
                    <select id="mao_obra" name="mao_obra">
                        <option value="Troca de óleo">Troca de óleo</option>
                        <option value="Troca de pneu">Troca de pneu</option>
                        <option value="Troca de relação">Troca de relação</option>
                    </select>
                    <div style="margin-top: 8px; display: flex; gap: 8px;">
                        <button type="button" class="btn-plus">Adicionar</button>
                        <button type="button" class="btn-plus" style="background-color: #dc3545;">Remover</button>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4"></textarea>
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
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const row = this.closest('tr');
                const modelo = row.dataset.modelo;
                const marca = row.dataset.marca;
                const dataAbertura = row.dataset.data_abertura;
                abrirModal(modelo, marca, dataAbertura);
            });
        });

        const historicoBtns = document.querySelectorAll('.btn-historico');
        historicoBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                abrirModalHistorico();
            });
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
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
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
    background: rgba(0,0,0,0.5);
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
    */ background-repeat: no-repeat;
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

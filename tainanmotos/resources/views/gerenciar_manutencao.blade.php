@extends('layouts.app')

@section('content')
<div class="gerenciar-container">
    <h2>Gerenciar Manutenções</h2>
    <p>Aqui você pode gerenciar as manutenções em aberto.</p>

    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Pesquisar...">
        <select id="search-type" name="search-type">
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="cor">Cor</option>
            <option value="placa">Placa</option>
        </select>
    </div>

    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Nome do Cliente</th>
                <th>Data de Abertura</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>XTZ 250 Lander</td>
                <td>Yamaha</td>
                <td>João Silva</td>
                <td>15/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
            <tr>
                <td>CB 500F</td>
                <td>Honda</td>
                <td>Maria Oliveira</td>
                <td>18/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
            <tr>
                <td>CG 160 Titan</td>
                <td>Honda</td>
                <td>Pedro Santos</td>
                <td>20/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
            <tr>
                <td>MT-03</td>
                <td>Yamaha</td>
                <td>Ana Souza</td>
                <td>22/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
            <tr>
                <td>Ninja 400</td>
                <td>Kawasaki</td>
                <td>Lucas Ferreira</td>
                <td>25/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
            <tr>
                <td>Fazer 250</td>
                <td>Yamaha</td>
                <td>Carla Mendes</td>
                <td>28/05/2023</td>
                <td class="btn-group">
                    <a href="#" class="btn-detalhes">Detalhes</a>
                    <a href="#" class="btn-concluir">Concluir</a>
                </td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar">Voltar</a>
</div>
@endsection

<style>
/* Estilos gerais */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* Container principal */
.gerenciar-container {
    width: 90%;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 10px;
}

/* Estilo da tabela */
.manutencao-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.manutencao-table th, .manutencao-table td {
    padding: 12px;
    text-align: left;
}

.manutencao-table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.manutencao-table tbody tr {
    background-color: #ffffff;
    transition: background 0.3s;
}

.manutencao-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.manutencao-table tbody tr:hover {
    background-color: #e6f7ff;
}

/* Estilo dos botões */
.btn-group {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn-detalhes, .btn-concluir {
    display: inline-block;
    padding: 8px 15px;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.2s;
    text-align: center;
}

.btn-detalhes {
    background-color: #28a745;
}

.btn-detalhes:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.btn-concluir {
    background-color: #dc3545;
}

.btn-concluir:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

/* Botão de voltar */
.btn-voltar {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-voltar:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Ajuste para a nova coluna */
.manutencao-table th:nth-child(4),
.manutencao-table td:nth-child(4) {
    text-align: center;
    width: 120px;
}

.search-container {
    margin-bottom: 20px;
}

.search-container input, .search-container select {
    padding: 8px;
    margin-right: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
</style>
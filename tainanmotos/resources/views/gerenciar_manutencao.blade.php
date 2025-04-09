@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Gerenciar Manutenções</h2>
    <p>Acompanhe e administre as manutenções em aberto no sistema.</p>

    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Buscar por modelo, marca ou nome do cliente...">
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
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>XTZ 250 Lander</td>
                <td>Yamaha</td>
                <td>João Silva</td>
                <td>15/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
            <tr>
                <td>CB 500F</td>
                <td>Honda</td>
                <td>Maria Oliveira</td>
                <td>18/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
            <tr>
                <td>CG 160 Titan</td>
                <td>Honda</td>
                <td>Pedro Santos</td>
                <td>20/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
            <tr>
                <td>MT-03</td>
                <td>Yamaha</td>
                <td>Ana Souza</td>
                <td>22/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
            <tr>
                <td>Ninja 400</td>
                <td>Kawasaki</td>
                <td>Lucas Ferreira</td>
                <td>25/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
            <tr>
                <td>Fazer 250</td>
                <td>Yamaha</td>
                <td>Carla Mendes</td>
                <td>28/05/2023</td>
                <td><a href="#" class="btn-visualizar"><i class="fas fa-search"></i> Ver Detalhes</a></td>
                <td><a href="#" class="btn-concluir"><i class="fas fa-check"></i> Concluir</a></td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
</div>
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

.search-container input, .search-container select {
    padding: 10px;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}

.search-container input:focus, .search-container select:focus {
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

.manutencao-table th, .manutencao-table td {
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
</style>
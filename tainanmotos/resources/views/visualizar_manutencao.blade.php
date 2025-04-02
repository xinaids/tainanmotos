@extends('layouts.app')

@section('content')
<div class="visualizar-container">
    <h2>Visualizar Manutenção</h2>
    <p>Aqui você pode ver o status das suas manutenções registradas.</p>

    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Cor</th>
                <th>Placa</th>
                <th>Dono</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>XTZ 250 Lander</td>
                <td>Yamaha</td>
                <td>Azul</td>
                <td>ABC-1234</td>
                <td>João Silva</td>
                <td>Em andamento</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
            <tr>
                <td>CB 500F</td>
                <td>Honda</td>
                <td>Vermelho</td>
                <td>XYZ-5678</td>
                <td>Maria Oliveira</td>
                <td>Concluído</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
            <tr>
                <td>CG 160 Titan</td>
                <td>Honda</td>
                <td>Preto</td>
                <td>DEF-9101</td>
                <td>Pedro Santos</td>
                <td>Pendente</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
            <tr>
                <td>MT-03</td>
                <td>Yamaha</td>
                <td>Branco</td>
                <td>GHI-1122</td>
                <td>Ana Souza</td>
                <td>Em andamento</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
            <tr>
                <td>Ninja 400</td>
                <td>Kawasaki</td>
                <td>Verde</td>
                <td>JKL-3344</td>
                <td>Lucas Ferreira</td>
                <td>Concluído</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
            <tr>
                <td>Fazer 250</td>
                <td>Yamaha</td>
                <td>Vermelho</td>
                <td>MNO-5566</td>
                <td>Carla Mendes</td>
                <td>Pendente</td>
                <td><a href="#" class="btn-detalhes">Detalhes</a></td>
            </tr>
        </tbody>
    </table>

    <a href="{{ url('/dashboard') }}" class="btn-voltar">Voltar</a>
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
.visualizar-container {
    width: 90%;
    max-width: 1100px;
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

/* Estilo da Tabela */
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

/* Estilo para os botões */
.btn-detalhes {
    display: inline-block;
    padding: 8px 15px;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.2s;
    text-align: center;
}

.btn-detalhes:hover {
    background-color: #218838;
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
</style>

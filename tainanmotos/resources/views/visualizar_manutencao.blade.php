@extends('layouts.app')

@section('content')
<div class="visualizar-container">
    <h2>Visualizar Manutenção</h2>
    <p>Aqui você pode ver o status das suas manutenções registradas.</p>

    <div class="manutencao-list">
        <div class="manutencao-item">
            <h3>Manutenção 1</h3>
            <p><strong>Modelo:</strong> XTZ 250 Lander</p>
            <p><strong>Marca:</strong> Yamaha</p>
            <p><strong>Cor:</strong> Azul</p>
            <p><strong>Placa:</strong> ABC-1234</p>
            <p><strong>Status:</strong> Em andamento</p>
            <a href="#" class="btn-detalhes">Detalhes</a>
        </div>

        <div class="manutencao-item">
            <h3>Manutenção 2</h3>
            <p><strong>Modelo:</strong> CB 500F</p>
            <p><strong>Marca:</strong> Honda</p>
            <p><strong>Cor:</strong> Vermelho</p>
            <p><strong>Placa:</strong> XYZ-5678</p>
            <p><strong>Status:</strong> Concluído</p>
            <a href="#" class="btn-detalhes">Detalhes</a>
        </div>
    </div>

    <a href="{{ url('/dashboard') }}" class="btn-voltar">Voltar</a>
</div>
@endsection

<style>
/* Estilos da tela de Visualizar Manutenção */
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

.visualizar-container {
    width: 80%;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    color: #333;
}

.manutencao-list {
    margin-top: 20px;
}

.manutencao-item {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: left;
    position: relative;
}

.manutencao-item h3 {
    margin: 0;
    color: #007bff;
}

.manutencao-item p {
    margin: 5px 0;
    color: #555;
}

/* Botão de detalhes */
.btn-detalhes {
    position: absolute;
    bottom: 10px;
    right: 10px;
    padding: 8px 12px;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-detalhes:hover {
    background-color: #218838;
}

/* Botão de voltar */
.btn-voltar {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition:
}
@extends('layouts.app')

@section('content')
<div class="gerenciar-container">
    <h2>Gerenciar Manutenções</h2>
    <p>Aqui você pode gerenciar as manutenções em aberto.</p>

    <div class="manutencao-list">
        <div class="manutencao-item">
            <h3>Manutenção 1</h3>
            <p><strong>Modelo:</strong> XTZ 250 Lander</p>
            <p><strong>Marca:</strong> Yamaha</p>
            <p><strong>Nome do Cliente:</strong> João Silva</p>
            
            <div class="btn-group">
                <a href="#" class="btn-detalhes">Detalhes</a>
                <a href="#" class="btn-concluir">Concluir</a>
            </div>
        </div>

        <div class="manutencao-item">
            <h3>Manutenção 2</h3>
            <p><strong>Modelo:</strong> CB 500F</p>
            <p><strong>Marca:</strong> Honda</p>
            <p><strong>Nome do Cliente:</strong> Maria Oliveira</p>
            
            <div class="btn-group">
                <a href="#" class="btn-detalhes">Detalhes</a>
                <a href="#" class="btn-concluir">Concluir</a>
            </div>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="btn-voltar">Voltar</a>
</div>
@endsection

<style>
/* Estilos da tela de Gerenciar Manutenção */
.gerenciar-container {
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

/* Grupo de botões */
.btn-group {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: flex;
    gap: 10px;
}

/* Botão de detalhes */
.btn-detalhes, .btn-concluir {
    padding: 8px 12px;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-detalhes {
    background-color: #28a745;
}

.btn-detalhes:hover {
    background-color: #218838;
}

.btn-concluir {
    background-color: #dc3545;
}

.btn-concluir:hover {
    background-color: #c82333;
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
    transition: background-color 0.3s;
}

.btn-voltar:hover {
    background-color: #0056b3;
}
</style>

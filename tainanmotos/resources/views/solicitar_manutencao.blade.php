@extends('layouts.app')

@section('content')
<div class="solicitar-container">
    <h2>Solicitar Manutenção</h2>
    <form action="#" method="POST">
        @csrf

        <!-- Modelo da moto -->
        <div class="form-group">
            <label for="modelo">Modelo da Moto</label>
            <input type="text" id="modelo" name="modelo" required>
        </div>

        <!-- Marca da moto -->
        <div class="form-group">
            <label for="marca">Marca da Moto</label>
            <input type="text" id="marca" name="marca" required>
        </div>

        <!-- Cor da moto -->
        <div class="form-group">
            <label for="cor">Cor da Moto</label>
            <input type="text" id="cor" name="cor" required>
        </div>

        <!-- Placa da moto -->
        <div class="form-group">
            <label for="placa">Placa da Moto</label>
            <input type="text" id="placa" name="placa" required>
        </div>

        <button type="submit" class="btn-submit">Solicitar Manutenção</button>
    </form>

    <!-- Botão de Voltar -->
    <a href="{{ route('dashboard') }}" class="btn-voltar">Voltar</a>
</div>
@endsection

<style>
/* Estilização geral */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* Container da página */
.solicitar-container {
    width: 50%;
    max-width: 500px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Estilização do formulário */
.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    color: rgb(18, 31, 46);
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #007bff;
}

/* Botão de envio */
.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-submit:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Botão de voltar */
.btn-voltar {
    display: block;
    margin-top: 15px;
    padding: 10px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-voltar:hover {
    background-color: #5a6268;
    transform: scale(1.05);
}
</style>

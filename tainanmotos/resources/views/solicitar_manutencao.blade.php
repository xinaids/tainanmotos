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
</div>
@endsection

<style>
/* Estilização geral */
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

/* Container da página */
.solicitar-container {
    width: 50%;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
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
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Botão de envio */
.btn-submit {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn-submit:hover {
    background-color: rgb(30, 50, 70);
}
</style>

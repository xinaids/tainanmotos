@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Cadastrar Mão de Obra</h2>
    <form action="#" method="POST">
        <!-- Nome da mão de obra -->
        <div class="form-group">
            <label for="nome_mao_obra">Nome da Mão de Obra <span class="required-asterisk">*</span></label>
            <input type="text" id="nome_mao_obra" name="nome_mao_obra" required>
        </div>

        <!-- Preço da mão de obra -->
        <div class="form-group">
            <label for="preco_mao_obra">Preço (R$) <span class="required-asterisk">*</span></label>
            <input type="number" step="0.01" id="preco_mao_obra" name="preco_mao_obra" required>
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-plus-circle"></i> Cadastrar Mão de Obra</button>
    </form>

    <!-- Botão de Voltar -->
    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>

    <!-- Botão Visualizar -->
    <div class="visualizar-buttons">
        <a href="{{ route('fabricante.index') }}" class="btn-visualizar">
            <i class="fas fa-eye"></i> Visualizar Cadastrados
        </a>
    </div>
</div>


@endsection

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 0;
}

.solicitar-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
}

.fade-in {
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.required-asterisk {
    color: red;
}

input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

input:focus {
    border-color: #1976d2;
    box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #1976d2;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.btn-submit:hover {
    background-color: #115293;
    transform: translateY(-2px);
}

.btn-voltar {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-voltar:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}
</style>

@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="modelos-container fade-in">
    <h2>Editar Mão de Obra</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('maoobra.update', $mao->codigo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome da Mão de Obra <span class="required-asterisk">*</span></label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $mao->nome) }}" required>
        </div>

        <div class="form-group">
            <label for="valor">Valor (R$) <span class="required-asterisk">*</span></label>
            <input type="number" id="valor" name="valor" value="{{ old('valor', $mao->valor) }}" step="0.01" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Salvar Alterações
        </button>
    </form>

    <a href="{{ route('maoobra.index') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar à Listagem
    </a>
</div>
<style>
body {
    background-color: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

.modelos-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
}

.fade-in {
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-group {
    margin-bottom: 18px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 6px;
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
    margin-top: 10px;
}

.btn-submit:hover {
    background-color: #115293;
    transform: translateY(-2px);
}

.btn-voltar {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 20px;
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

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    text-align: left;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
</style>

@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="fabricantes-container fade-in">
    <h2>Editar Fabricante</h2>

    <form action="{{ route('fabricante.update', $fabricante->codigo) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome do Fabricante</label>
            <input type="text" id="nome" name="nome" value="{{ $fabricante->nome }}" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Salvar Alterações
        </button>
    </form>

    <!-- Botão de Voltar -->
    <a href="{{ route('fabricante.index') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

.fabricantes-container {
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
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.edit-form .form-group {
    margin-bottom: 15px;
    text-align: left;
}

.edit-form label {
    display: block;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
    font-size: 14px;
}

.edit-form input {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
    background-color: #fafafa;
}

.edit-form input:focus {
    border-color: #1976d2;
    box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    background-color: #ffffff;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #1976d2;
    color: white;
    border: none;
    border-radius: 8px;
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
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-voltar:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}
</style>
@endsection

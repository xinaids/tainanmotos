@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="edit-modelo-container fade-in">
    <h2>Editar Modelo</h2>

    <form method="POST" action="{{ route('modelo.update', $modelo->codigo) }}" class="edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome do Modelo:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $modelo->nome) }}" required>
        </div>

        <div class="form-group">
            <label for="fabricante_id">Fabricante:</label>
            <select name="fabricante_id" id="fabricante_id" required>
                <option value="">Selecione um fabricante</option>
                @foreach ($fabricantes as $fabricante)
                <option value="{{ $fabricante->codigo }}" {{ $modelo->cod_fabricante == $fabricante->codigo ? 'selected' : '' }}>
                    {{ $fabricante->nome }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-salvar">Salvar</button>
            <a href="{{ route('modelo.index') }}" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f1f1f1;
        margin: 0;
        padding: 0;
    }

    .edit-modelo-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .edit-modelo-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .edit-form .form-group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .edit-form label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .edit-form input,
    .edit-form select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .btn-salvar {
        padding: 10px 20px;
        background-color: #28a745;
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-salvar:hover {
        background-color: #218838;
    }

    .btn-cancelar {
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-cancelar:hover {
        background-color: #5a6268;
    }
</style>
@endsection
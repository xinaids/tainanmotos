@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Editar Peça</h2>

    <form action="{{ route('pecas.update', $peca->codigo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome da Peça</label>
            <input type="text" id="nome" name="nome" value="{{ $peca->nome }}" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="number" step="0.01" id="preco" name="preco" value="{{ $peca->preco }}" required>
        </div>

        <div class="form-group">
            <label for="cod_modelo">Modelo</label>
            <select id="cod_modelo" name="cod_modelo" required>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo->codigo }}" {{ $peca->cod_modelo == $modelo->codigo ? 'selected' : '' }}>
                        {{ $modelo->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="filtro-btn">Salvar Alterações</button>
        <a href="{{ route('pecas.index') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </form>
</div>
@endsection

<style>
    /* Estilos do body - Conforme o CSS fornecido */
    body {
        font-family: Arial, sans-serif; /* Usando Arial como solicitado */
        background-color: #f1f1f1;
        margin: 0;
        padding: 0;
    }

    /* Container principal - Adaptado de .fabricantes-container */
    .solicitar-container {
        max-width: 600px; /* Ajuste para formulários */
        margin: 40px auto;
        padding: 25px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center; /* Centraliza o conteúdo dentro do container */
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

    /* Estilos para grupos de formulário */
    .form-group {
        margin-bottom: 15px;
        text-align: left; /* Alinha o texto do label e input à esquerda */
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px; /* Espaçamento entre label e input */
    }

    /* Estilos para inputs e selects */
    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box; /* Garante que padding não aumente a largura total */
        transition: border-color 0.3s, box-shadow 0.3s;
        background-color: #fafafa;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
        outline: none;
    }

    /* Estilo do botão Salvar Alterações - Usando .filtro-btn */
    .filtro-btn {
        padding: 10px 16px;
        font-size: 16px; /* Aumentado um pouco para botões de ação principal */
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        margin-top: 10px; /* Espaçamento acima do botão */
    }

    .filtro-btn:hover {
        background-color: #125a9c;
    }

    /* Estilo do botão Cancelar - .btn-voltar */
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

    /* Media queries para responsividade (adaptadas do seu CSS) */
    @media (max-width: 768px) {
        .solicitar-container {
            margin: 20px auto;
            padding: 15px;
        }

        h2 {
            font-size: 22px;
        }

        .form-group label,
        input[type="text"],
        input[type="number"],
        select {
            font-size: 13px;
        }

        .filtro-btn,
        .btn-voltar {
            padding: 8px 15px;
            font-size: 14px;
        }
    }
</style>
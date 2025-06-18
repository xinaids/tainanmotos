@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="modelos-container fade-in">
    <h2>Mãos de Obra Cadastradas</h2>

    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif


    <form method="GET" action="{{ route('maoobra.index') }}" class="filtro-form">
        <div class="filtro-row">
            <div class="filtro-campo">
                <label for="ordenar_por">Ordenar por:</label>
                <select name="ordenar_por" id="ordenar_por">
                    <option value="nome" {{ request('ordenar_por', 'nome') == 'nome' ? 'selected' : '' }}>Nome</option>
                    <option value="valor" {{ request('ordenar_por') == 'valor' ? 'selected' : '' }}>Valor</option>
                </select>

                <select name="ordem" id="ordem">
                    <option value="asc" {{ request('ordem', 'asc') == 'asc' ? 'selected' : '' }}>Crescente</option>
                    <option value="desc" {{ request('ordem') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                </select>
            </div>

            <div class="filtro-campo">
                <label for="busca">Pesquisar:</label>
                <input type="text" name="busca" id="busca" placeholder="Buscar mão de obra..." value="{{ request('busca') }}">
            </div>

            <button type="submit" class="btn-submit filtro-btn">
                <i class="fas fa-search"></i> Filtrar
            </button>
        </div>
    </form>



    <div class="table-container">
        <table class="modelos-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maos as $mao)
                <tr>
                    <td>{{ $mao->nome }}</td>
                    <td>{{ number_format($mao->valor, 2, ',', '.') }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('maoobra.edit', $mao->codigo) }}" class="btn-action edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('maoobra.destroy', $mao->codigo) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" onclick="return confirm('Deseja realmente excluir esta mão de obra?')" title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('maoobra.create') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>

</div>

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .modelos-container {
        max-width: 900px;
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

    .table-container {
        overflow-x: auto;
    }

    .modelos-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .modelos-table thead {
        background-color: #1976d2;
        color: white;
    }

    .modelos-table th,
    .modelos-table td {
        padding: 12px 15px;
        text-align: center;
    }

    .modelos-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .modelos-table tbody tr:hover {
        background-color: #e3f2fd;
    }

    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        text-decoration: none;
    }

    .btn-action i {
        color: white;
        font-size: 14px;
    }

    .btn-action.edit {
        background-color: #ffc107;
    }

    .btn-action.edit:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }

    .btn-action.delete {
        background-color: #dc3545;
    }

    .btn-action.delete:hover {
        background-color: #c82333;
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

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .filtro-form {
        margin-bottom: 20px;
        text-align: center;
    }

    .filtro-row {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .filtro-campo {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    .filtro-campo label {
        font-size: 14px;
        margin-bottom: 4px;
        font-weight: bold;
        color: #333;
    }

    .filtro-campo input,
    .filtro-campo select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .filtro-btn {
        padding: 10px 16px;
        font-size: 14px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .filtro-btn:hover {
        background-color: #125a9c;
    }
</style>
@endsection
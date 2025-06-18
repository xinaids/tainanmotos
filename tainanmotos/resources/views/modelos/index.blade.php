@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="modelos-container fade-in">
    <h2>Modelos Cadastrados</h2>

    <!-- Filtro de ordenação e campo de pesquisa -->
    <form method="GET" action="{{ route('modelo.index') }}" class="filtro-form">
        <div class="filtro-row">
            <div class="filtro-campo">
                <label for="ordenar">Ordenar por:</label>
                <select name="ordenar" id="ordenar">
                    <option value="codigo" {{ $ordenarPor == 'codigo' ? 'selected' : '' }}>Código</option>
                    <option value="nome" {{ $ordenarPor == 'nome' ? 'selected' : '' }}>Nome</option>
                </select>

                <select name="ordem" id="ordem">
                    <option value="asc" {{ $ordem == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ $ordem == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>
            </div>

            <div class="filtro-campo">
                <label for="pesquisa">Pesquisar:</label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar modelo..." value="{{ request('pesquisa') }}">
            </div>

            <button type="submit" class="btn-submit filtro-btn">Filtrar</button>
        </div>
    </form>

    @if($modelos->count() > 0)
    <div class="table-container">
        <table class="modelos-table">
            <thead>
                <tr>
                    <th>Nome do Modelo</th>
                    <th>Fabricante</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modelos as $modelo)
                <tr>
                    <td>{{ $modelo->nome }}</td>
                    <td>{{ $modelo->fabricante_nome }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('modelo.edit', $modelo->codigo) }}" class="btn-action edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('modelo.destroy', $modelo->codigo) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" onclick="return confirm('Tem certeza que deseja excluir?')" title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- Paginação (padrão, limpa, sem ícones gigantes) -->
    <div class="pagination-container">
        {{ $modelos->links('pagination::bootstrap-4') }}
    </div>
    @else
    <p class="no-modelos">Nenhum modelo cadastrado.</p>
    @endif

    <a href="{{ route('modelo.create') }}" class="btn-voltar">
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
        text-align: left;
    }

    .modelos-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .modelos-table tbody tr:hover {
        background-color: #e3f2fd;
    }

    .no-modelos {
        color: #666;
        text-align: center;
        font-style: italic;
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

    .actions-cell {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        text-decoration: none;
    }

    .actions-cell .btn-action i {
        color: white;
        font-size: 13px !important;
        line-height: 1;
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

    .filtro-form {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        margin-bottom: 20px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .filtro-row {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
        width: 100%;
        justify-content: space-between;
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

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .pagination {
        display: flex;
        list-style: none;
        gap: 6px;
        padding: 0;
    }

    .pagination li a,
    .pagination li span {
        padding: 6px 12px;
        border: 1px solid #ccc;
        background-color: white;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.2s, color 0.2s;
    }

    .pagination li.active span,
    .pagination li a:hover {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination svg {
        display: none !important;
    }
</style>
@endsection
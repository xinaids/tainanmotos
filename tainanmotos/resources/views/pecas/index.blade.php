@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Peças Cadastradas</h2>

    <table class="peca-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço (R$)</th>
                <th>Modelo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pecas as $peca)
            <tr>
                <td>{{ $peca->nome }}</td>
                <td>{{ number_format($peca->preco, 2, ',', '.') }}</td>
                <td>{{ $peca->modelo->nome }}</td>
                <td class="actions-cell">
                    <a href="{{ route('pecas.edit', $peca->codigo) }}" class="btn-action edit" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('pecas.destroy', $peca->codigo) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action delete" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta peça?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination-container">
        {{ $pecas->links('pagination::bootstrap-4') }}
    </div>


    <a href="{{ route('pecas.create') }}" class="btn-voltar"><i class="fas fa-plus-circle"></i> Cadastrar Nova Peça</a>
    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>


</div>
@endsection

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .solicitar-container {
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

    .peca-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        font-size: 15px;
    }

    .peca-table thead {
        background-color: #1976d2;
        color: white;
    }

    .peca-table th,
    .peca-table td {
        padding: 12px 15px;
        text-align: left;
    }

    .peca-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .peca-table tbody tr:hover {
        background-color: #e3f2fd;
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
        justify-content: flex-start;
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
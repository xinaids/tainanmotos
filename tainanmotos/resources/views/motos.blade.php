@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="motos-container fade-in">
    <h2>Motos Cadastradas</h2>

    {{-- Formulário de Busca --}}
    <form method="GET" action="{{ route('moto.index') }}" class="search-form">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Buscar por placa, modelo, usuário..."
            value="{{ request('search') }}"
        >
        <button
            type="submit"
            class="btn-search"
        >
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>

    {{-- Tabela de Motos --}}
    <div class="table-responsive">
        <table class="motos-table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cor</th>
                    <th>Ano</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Usuário</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($motos as $moto)
                <tr>
                    <td>{{ $moto->placa }}</td>
                    <td>{{ $moto->cor }}</td>
                    <td>{{ $moto->ano }}</td>
                    <td>{{ $moto->modelo->nome ?? '-' }}</td>
                    <td>{{ $moto->modelo->fabricante->nome ?? '-' }}</td>
                    <td>{{ $moto->usuario->nome ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-motos">Nenhuma moto encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="pagination-container">
        {{ $motos->withQueryString()->links('pagination::tailwind') }} {{-- Usando o tema Tailwind para paginação --}}
    </div>

    {{-- Botão Voltar --}}
    <div class="back-button-container">
        <a href="{{ route('dashboard') }}" class="btn-voltar-custom">
            <i class="fas fa-arrow-left"></i> Voltar ao Painel
        </a>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .motos-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 25px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        animation: fadeIn 0.6s ease-in-out;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: bold;
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

    /* Search Form */
    .search-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        gap: 15px;
    }

    .search-input {
        width: 100%;
        max-width: 400px;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: border-color 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
    }

    .search-input:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    }

    .btn-search {
        padding: 12px 25px;
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

    .btn-search:hover {
        background-color: #115293;
        transform: translateY(-2px);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .motos-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .motos-table thead {
        background-color: #1976d2;
        color: white;
    }

    .motos-table th {
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 16px;
    }

    .motos-table tbody tr:nth-child(even) {
        background-color: #f8faff; /* Lighter blue for even rows */
    }

    .motos-table tbody tr:hover {
        background-color: #e3f2fd; /* Light blue on hover */
        transition: background-color 0.15s ease-in-out;
    }

    .motos-table td {
        padding: 12px 20px;
        text-align: left;
        color: #333;
        font-size: 14px;
        border-bottom: 1px solid #eee;
    }

    .motos-table tbody tr:last-child td {
        border-bottom: none;
    }

    .no-motos {
        padding: 20px;
        text-align: center;
        color: #666;
        font-size: 16px;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    /* Overriding Laravel's Tailwind Pagination Styles for a more custom look */
    .pagination a,
    .pagination span {
        padding: 10px 15px;
        border: 1px solid #ddd;
        margin: 0 5px;
        border-radius: 8px;
        text-decoration: none;
        color: #1976d2;
        transition: all 0.3s ease-in-out;
        font-weight: 500;
    }

    .pagination a:hover {
        background-color: #e3f2fd;
        border-color: #90caf9;
        color: #115293;
    }

    .pagination .active span {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
        font-weight: 600;
    }

    .pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #f0f0f0;
        color: #aaa;
        border-color: #e0e0e0;
    }


    /* Back Button */
    .back-button-container {
        margin-top: 30px;
    }

    .btn-voltar-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 25px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-voltar-custom:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .motos-container {
            margin: 20px auto;
            padding: 15px;
        }

        h2 {
            font-size: 24px;
        }

        .search-form {
            flex-direction: column;
            gap: 10px;
        }

        .motos-table th,
        .motos-table td {
            padding: 10px 15px;
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .motos-table th,
        .motos-table td {
            padding: 8px 10px;
            font-size: 12px;
        }

        .btn-search,
        .btn-voltar-custom {
            width: 100%;
        }

        .search-input {
            font-size: 13px;
        }
    }
</style>

{{-- Remove Tailwind CDN if you are now using custom CSS extensively --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
{{-- Script para a fonte Inter (if not already globally) --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

@endsection
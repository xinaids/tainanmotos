@extends('layouts.app')
@section('content')
@include('partials.header')

<div class="container fade-in">
    <h2>Motos Cadastradas</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Cor</th>
                <th>Ano</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Usuário</th> <!-- NOVO -->
            </tr>
        </thead>
        <tbody>
            @foreach ($motos as $moto)
            <tr>
                <td>{{ $moto->placa }}</td>
                <td>{{ $moto->cor }}</td>
                <td>{{ $moto->ano }}</td>
                <td>{{ $moto->modelo->nome ?? '-' }}</td>
                <td>{{ $moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $moto->usuario->nome ?? '-' }}</td> <!-- NOVO -->
            </tr>
            @endforeach
        </tbody>

    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
</div>

<style>
    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 25px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .table th {
        background-color: #1976d2;
        color: white;
    }

    .btn-voltar {
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-voltar:hover {
        background-color: #5a6268;
    }
</style>
@endsection
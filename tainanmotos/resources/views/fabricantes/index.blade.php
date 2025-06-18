@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="fabricantes-container fade-in">
    <h2>Fabricantes Cadastrados</h2>

    <!-- Filtro com valor padrão: Nome (A-Z) -->
<!-- Filtro de ordenação e campo de pesquisa -->
<form method="GET" action="{{ route('fabricante.index') }}" class="filtro-form">
    <div class="filtro-row">
        <div class="filtro-campo">
            <label for="ordenar_por">Ordenar por:</label>
            <select name="ordenar_por" id="ordenar_por">
                <option value="nome" {{ request('ordenar_por', 'nome') == 'nome' ? 'selected' : '' }}>Nome</option>
                <option value="codigo" {{ request('ordenar_por') == 'codigo' ? 'selected' : '' }}>Código</option>
            </select>

            <select name="ordem" id="ordem">
                <option value="asc" {{ request('ordem', 'asc') == 'asc' ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('ordem') == 'desc' ? 'selected' : '' }}>Z-A</option>
            </select>
        </div>

        <div class="filtro-campo">
            <label for="pesquisa">Pesquisar:</label>
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar fabricante..." value="{{ request('pesquisa') }}">
        </div>

        <button type="submit" class="btn-submit filtro-btn">Filtrar</button>
    </div>
</form>


    @if($fabricantes->count() > 0)
        <div class="table-container">
            <table class="fabricantes-table">
                <thead>
                    <tr>
                        <!-- <th>Código</th> -->
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fabricantes as $fabricante)
                        <tr>
                            <!-- <td>{{ $fabricante->codigo }}</td>  -->
                            <td>{{ $fabricante->nome }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('fabricante.edit', $fabricante->codigo) }}" class="btn-action edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('fabricante.destroy', $fabricante->codigo) }}" method="POST" style="display: inline;">
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

        <!-- Paginação com bootstrap-4 (sem ícones gigantes) -->
        <div class="pagination-container">
            {{ $fabricantes->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p class="no-fabricantes">Nenhum fabricante cadastrado.</p>
    @endif

    <a href="{{ route('cadastrarfabricante') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<style>
body {
    background-color: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.fabricantes-container {
    max-width: 800px;
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

/* Filtro */
.filtro-form {
    margin-bottom: 20px;
    text-align: center;
}

.filtro-form label {
    font-weight: 600;
    color: #333;
    margin-right: 8px;
}

.filtro-form select {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fafafa;
    font-size: 14px;
    cursor: pointer;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.filtro-form select:focus {
    border-color: #1976d2;
    box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    outline: none;
}

.table-container {
    overflow-x: auto;
}

.fabricantes-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.fabricantes-table thead {
    background-color: #1976d2;
    color: white;
}

.fabricantes-table th,
.fabricantes-table td {
    padding: 12px 15px;
    text-align: left;
}

.fabricantes-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.fabricantes-table tbody tr:hover {
    background-color: #e3f2fd;
}

.no-fabricantes {
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
    justify-content: center;
    align-items: center; 
    height: 100%;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
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

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding-left: 0;
}

.pagination li {
    display: inline;
}

.pagination li a,
.pagination li span {
    display: inline-block;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #ffffff;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.pagination li.active span,
.pagination li a:hover {
    background-color: #1976d2;
    color: white;
    border-color: #1976d2;
}

.pagination li.disabled span {
    color: #999;
    background-color: #f1f1f1;
    cursor: not-allowed;
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



</style>
@endsection

@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Usuários Cadastrados</h2>

    <!-- Filtros -->
    <form method="GET" action="{{ route('usuarios.index') }}" class="filtro-form">
        <div class="filtro-row">
            <div class="filtro-campo">
                <label for="ordenar_por">Ordenar por:</label>
                <select name="ordenar_por" id="ordenar_por">
                    <option value="nome" {{ request('ordenar_por', 'nome') == 'nome' ? 'selected' : '' }}>Nome</option>
                    <option value="email" {{ request('ordenar_por') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="cpf" {{ request('ordenar_por') == 'cpf' ? 'selected' : '' }}>CPF</option>
                </select>

                <select name="ordem" id="ordem">
                    <option value="asc" {{ request('ordem', 'asc') == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ request('ordem') == 'desc' ? 'selected' : '' }}>Z-A </option>
                </select>
            </div>

            <div class="filtro-campo">
                <label for="pesquisa">Pesquisar:</label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar usuário..." value="{{ request('pesquisa') }}">
            </div>

            <button type="submit" class="btn-submit filtro-btn">Filtrar</button>
        </div>
    </form>

    <table class="peca-table"> {{-- Reutilizando a classe peca-table para o estilo --}}
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->cpf }}</td>
                <td>{{ $usuario->telefone }}</td>
                <td>
                    @switch($usuario->tipo)
                        @case(1)
                            Cliente
                            @break
                        @case(2)
                            Administrador
                            @break
                        @default
                            Desconhecido
                    @endswitch
                </td>
                <td class="actions-cell">
                    {{-- Usando $usuario->cpf como parâmetro para a rota de edição --}}
                    <a href="{{ route('usuarios.edit', $usuario->cpf) }}" class="btn-action edit" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    {{-- Usando $usuario->cpf como parâmetro para a rota de exclusão --}}
                    <form action="{{ route('usuarios.destroy', $usuario->cpf) }}" method="POST" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action delete" title="Excluir">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Nenhum usuário encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination-container">
        {{ $usuarios->links('pagination::bootstrap-4') }}
    </div>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>
</div>
@endsection

@section('scripts')
{{-- Importa SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmação de exclusão com SweetAlert2
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Impede o envio padrão do formulário
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Envia o formulário se confirmado
                    }
                });
            });
        });
    });
</script>
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

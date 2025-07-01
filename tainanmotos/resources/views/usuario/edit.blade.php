@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Editar Usuário</h2>

    {{-- O action do formulário agora usa $usuario->cpf como parâmetro --}}
    <form action="{{ route('usuarios.update', $usuario->cpf) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="{{ $usuario->nome }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" value="{{ $usuario->telefone }}" maxlength="15" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="{{ $usuario->cpf }}" maxlength="14" required readonly> {{-- CPF deve ser readonly para evitar alteração da PK --}}
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Usuário:</label>
            <select id="tipo" name="tipo" required>
                <option value="1" {{ $usuario->tipo == 1 ? 'selected' : '' }}>Cliente</option>
                <option value="2" {{ $usuario->tipo == 2 ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        {{-- Campos de senha opcionais --}}
        <div class="form-group">
            <label for="password">Nova Senha (opcional):</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Nova Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
            <button type="submit" class="filtro-btn">Salvar Alterações</button>
            <a href="{{ route('usuarios.index') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
{{-- Importa SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cpfInput = document.getElementById("cpf");
        const telefoneInput = document.getElementById("telefone");

        // Máscara para CPF
        cpfInput.addEventListener("input", function () {
            let value = cpfInput.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            cpfInput.value = value;
        });

        // Máscara para Telefone
        telefoneInput.addEventListener("input", function () {
            let value = telefoneInput.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
            value = value.replace(/(\d{5})(\d{1,4})$/, "$1-$2");
            telefoneInput.value = value;
        });

        // Validação ao submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            let errors = [];

            if (telefone.length !== 11) {
                errors.push("O telefone deve ter exatamente 11 dígitos (incluindo DDD).");
            }
            if (cpf.length !== 11) {
                errors.push("O CPF deve ter exatamente 11 dígitos.");
            }
            if (password && password.length < 8) {
                errors.push("A nova senha deve ter no mínimo 8 caracteres.");
            }
            if (password && password !== passwordConfirmation) {
                errors.push("As senhas não coincidem.");
            }

            if (errors.length > 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Erro de Validação!',
                    html: errors.map(err => `<li>${err}</li>`).join(''),
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
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

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="tel"],
    input[type="password"], /* Adicionado para garantir estilo para campos de senha */
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
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="password"]:focus, /* Adicionado para garantir estilo para campos de senha */
    select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
        outline: none;
    }

    .filtro-btn { /* Usado para o botão Salvar Alterações */
        padding: 10px 16px;
        font-size: 16px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        margin-top: 10px;
    }

    .filtro-btn:hover {
        background-color: #125a9c;
    }

    .btn-voltar { /* Usado para o botão Cancelar */
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 20px; /* Ajustado para estar alinhado com o botão de salvar */
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
</style>

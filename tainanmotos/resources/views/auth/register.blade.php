@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full bg-white rounded-xl shadow-2xl p-8 transform transition-all duration-500 fade-in">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-8 text-center leading-tight">Cadastro</h2>

        <form id="register-form" action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            {{-- NOME --}}
            <div class="input-group">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo: <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                    placeholder="Seu nome completo"
                >
            </div>

            {{-- E-MAIL --}}
            <div class="input-group">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email: <span class="text-red-500">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                    placeholder="seu.email@example.com"
                >
            </div>

            {{-- TELEFONE --}}
            <div class="input-group">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone: <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        maxlength="15"
                        required
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                        placeholder="(XX) XXXXX-XXXX"
                    >
                </div>
            </div>

            {{-- CPF (11 dígitos) --}}
            <div class="input-group">
                <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF: <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        maxlength="14"
                        required
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                        placeholder="XXX.XXX.XXX-XX"
                    >
                </div>
            </div>

            {{-- SENHA --}}
            <div class="input-group">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha: <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800 pr-10"
                        placeholder="Mínimo 8 caracteres e 1 número"
                    >
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('password')">
                        <i id="eye-icon-password" class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
                    </span>
                </div>
            </div>

            {{-- CONFIRMAR SENHA --}}
            <div class="input-group">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha: <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800 pr-10"
                        placeholder="Confirme sua senha"
                    >
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('password_confirmation')">
                        <i id="eye-icon-password_confirmation" class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
                    </span>
                </div>
            </div>

            <button
                type="submit"
                class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition duration-300 shadow-lg flex items-center justify-center gap-2"
            >
                <i class="fas fa-user-plus"></i> Cadastrar
            </button>
        </form>

        <p class="mt-8 text-center text-gray-600 text-base">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 transition duration-300">Faça login aqui</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Script para o Font Awesome (ícones) --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    // Função para alternar a visibilidade da senha
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('eye-icon-' + id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const cpfInput = document.getElementById("cpf");
        const phoneInput = document.getElementById("phone");

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
        phoneInput.addEventListener("input", function () {
            let value = phoneInput.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
            value = value.replace(/(\d{5})(\d{1,4})$/, "$1-$2");
            phoneInput.value = value;
        });

        const form = document.getElementById("register-form");
        form.addEventListener("submit", function (e) {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.replace(/\D/g, ""); // Apenas dígitos para validação
            const cpf = document.getElementById("cpf").value.replace(/\D/g, ""); // Apenas dígitos para validação
            const password = document.getElementById("password").value.trim();
            const passwordConfirmation = document.getElementById("password_confirmation").value.trim();

            let errors = [];

            if (!name) errors.push("O nome completo é obrigatório.");
            if (!email) errors.push("O email é obrigatório.");

            // Validação de Telefone - 11 dígitos
            if (!phone) {
                errors.push("O telefone é obrigatório.");
            } else if (phone.length !== 11) {
                errors.push("O telefone deve ter exatamente 11 dígitos (incluindo DDD).");
            }

            // Validação de CPF - 11 dígitos
            if (!cpf) {
                errors.push("O CPF é obrigatório.");
            } else if (cpf.length !== 11) {
                errors.push("O CPF deve ter exatamente 11 dígitos.");
            }

            if (!password) {
                errors.push("A senha é obrigatória.");
            } else if (password.length < 8) {
                errors.push("A senha deve ter no mínimo 8 caracteres.");
            } else if (!/\d/.test(password)) { // Verifica se contém pelo menos um número
                errors.push("A senha deve conter pelo menos um número.");
            }

            // Validação de Senhas Iguais
            if (password !== passwordConfirmation) {
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

<style>
    /*
    Os estilos Tailwind são aplicados diretamente nas classes HTML.
    Aqui ficam apenas estilos complementares ou específicos que não são puramente Tailwind.
    */
    body {
        font-family: 'Inter', sans-serif; /* Usando a fonte Inter */
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
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
</style>

{{-- Adicione o CDN do Tailwind CSS se não estiver usando PostCSS/Webpack --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Script para a fonte Inter (se não estiver já globalmente) --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

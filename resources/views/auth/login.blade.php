@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8 transform transition-all duration-500 fade-in">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-8 text-center leading-tight">Login</h2>
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div class="input-group">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                    placeholder="seu.email@example.com"
                >
            </div>
            <div class="input-group">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-300 placeholder-gray-400 text-gray-800"
                    placeholder="••••••••"
                >
            </div>
            <button
                type="submit"
                class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition duration-300 shadow-lg flex items-center justify-center gap-2"
            >
                <i class="fas fa-sign-in-alt"></i> Entrar
            </button>
        </form>

        <p class="mt-8 text-center text-gray-600 text-base">
            Ainda não tem uma conta?
            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 transition duration-300">Cadastre-se aqui</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Importa SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Exibe alerta de cadastro realizado com sucesso --}}
    @if(session('register_success'))
        <script>
            Swal.fire({
                title: 'Cadastro concluído!',
                text: 'Seu cadastro foi realizado com sucesso. Faça login para continuar.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection

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

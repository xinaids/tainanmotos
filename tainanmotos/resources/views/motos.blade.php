@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl w-full bg-white rounded-xl shadow-lg p-8 transform transition-all duration-500 fade-in">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-8 text-center leading-tight">Motos Cadastradas</h2>

        {{-- Formulário de Busca --}}
        <form method="GET" action="{{ route('moto.index') }}" class="flex flex-col sm:flex-row items-center justify-center mb-8 gap-4">
            <input
                type="text"
                name="search"
                class="flex-grow w-full sm:w-auto p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 shadow-sm text-gray-700"
                placeholder="Buscar por placa, modelo, usuário..."
                value="{{ request('search') }}"
            >
            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-md flex items-center justify-center gap-2"
            >
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>

        {{-- Tabela de Motos --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md mb-8">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Placa</th>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Cor</th>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Ano</th>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Modelo</th>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Marca</th>
                        <th class="py-4 px-6 text-left font-semibold text-lg">Usuário</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($motos as $moto)
                    <tr class="even:bg-blue-50 hover:bg-blue-100 transition duration-150 border-b border-gray-200">
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->placa }}</td>
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->cor }}</td>
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->ano }}</td>
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->modelo->nome ?? '-' }}</td>
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->modelo->fabricante->nome ?? '-' }}</td>
                        <td class="py-3 px-6 text-gray-800 text-base">{{ $moto->usuario->nome ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center text-gray-600 text-lg">Nenhuma moto encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="flex justify-center mt-6">
            {{ $motos->withQueryString()->links('pagination::tailwind') }} {{-- Usando o tema Tailwind para paginação --}}
        </div>

        {{-- Botão Voltar --}}
        <div class="flex justify-center mt-10">
            <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition duration-300 shadow-lg flex items-center gap-3">
                <i class="fas fa-arrow-left"></i> Voltar ao Painel
            </a>
        </div>
    </div>
</div>

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

    /* Ajustes para Paginação Laravel com Tailwind */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 1rem 0;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        margin: 0 0.25rem;
        border-radius: 0.375rem;
        text-decoration: none;
        color: #4a5568;
        transition: all 0.2s ease-in-out;
    }

    .pagination a:hover {
        background-color: #edf2f7;
        border-color: #cbd5e0;
    }

    .pagination .active span {
        background-color: #4299e1; /* Cor azul Tailwind 500 */
        color: white;
        border-color: #4299e1;
    }

    .pagination .disabled span {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

{{-- Adicione o CDN do Tailwind CSS se não estiver usando PostCSS/Webpack --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Script para a fonte Inter (se não estiver já globalmente) --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

@endsection

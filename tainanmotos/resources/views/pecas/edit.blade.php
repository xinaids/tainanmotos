@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Editar Peça</h2>

    <form action="{{ route('pecas.update', $peca->codigo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome da Peça</label>
            <input type="text" id="nome" name="nome" value="{{ $peca->nome }}" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="number" step="0.01" id="preco" name="preco" value="{{ $peca->preco }}" required>
        </div>

        <div class="form-group">
            <label for="cod_modelo">Modelo</label>
            <select id="cod_modelo" name="cod_modelo" required>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo->codigo }}" {{ $peca->cod_modelo == $modelo->codigo ? 'selected' : '' }}>
                        {{ $modelo->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="filtro-btn">Salvar Alterações</button>
        <a href="{{ route('pecas.index') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </form>
</div>
@endsection

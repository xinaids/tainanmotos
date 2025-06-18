@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Estatísticas de Chamados por Modelo</h2>

    <div id="tree-container"></div>

    <a href="{{ route('dashboard') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<script>
    const dados = @json($dados);

    const container = document.getElementById('tree-container');

    dados.forEach(fab => {
        const detailsFab = document.createElement('details');
        detailsFab.open = true;

        const summaryFab = document.createElement('summary');
        summaryFab.innerHTML = `<strong>${fab.fabricante}</strong>`;

        const ulModelos = document.createElement('ul');
        fab.modelos.forEach(modelo => {
            const li = document.createElement('li');
            li.textContent = `${modelo.nome} — ${modelo.qtd_chamados} chamado(s)`;
            ulModelos.appendChild(li);
        });

        detailsFab.appendChild(summaryFab);
        detailsFab.appendChild(ulModelos);
        container.appendChild(detailsFab);
    });
</script>

<style>
#tree-container {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    font-family: monospace;
    line-height: 1.6;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

details summary {
    font-size: 18px;
    cursor: pointer;
    padding: 6px;
    background: #1976d2;
    color: white;
    border-radius: 6px;
    margin-bottom: 5px;
}

ul {
    list-style-type: disc;
    padding-left: 20px;
}

li {
    margin: 4px 0;
}
</style>
@endsection

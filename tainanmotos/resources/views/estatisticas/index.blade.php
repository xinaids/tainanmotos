@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Estatísticas de Chamados</h2>

    {{-- Seção do Gráfico de Fabricantes --}}
    <div class="chart-section">
        <h3>Chamados por Fabricante</h3>
        <canvas id="fabricantesChart"></canvas>
    </div>

    {{-- Seção do Gráfico de Modelos --}}
    <div class="chart-section">
        <h3>Chamados por Modelo</h3>
        <canvas id="modelosChart"></canvas>
    </div>

    <h2 style="margin-top: 30px;">Detalhamento por Fabricante e Modelo</h2>
    <div id="tree-container"></div>

    <a href="{{ route('dashboard') }}" class="btn-voltar">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados de exemplo fornecidos pelo seu controlador Laravel (assumindo que $dados já contém o formato correto)
    const dadosChamados = @json($dados);

    // --- Dados Agregados para os Gráficos (Você precisará gerar isso no seu Controller) ---
    // EXEMPLO DE DADOS - VOCÊ PRECISA SUBSTITUIR ISSO PELOS DADOS REAIS DO BACKEND
    const fabricantesData = []; // Ex: [{ fabricante: 'Honda', qtd_chamados: 10 }, { fabricante: 'Yamaha', qtd_chamados: 7 }]
    const modelosData = []; // Ex: [{ modelo: 'CBR 600RR', qtd_chamados: 5 }, { modelo: 'MT-07', qtd_chamados: 4 }]

    // Lógica para agregar os dados a partir de 'dadosChamados'
    // Esta parte pode ser movida para o backend para maior eficiência,
    // mas está aqui para demonstração.
    let tempFabricantes = {};
    let tempModelos = {};

    dadosChamados.forEach(fab => {
        tempFabricantes[fab.fabricante] = (tempFabricantes[fab.fabricante] || 0); // Inicializa se não existir
        fab.modelos.forEach(modelo => {
            tempFabricantes[fab.fabricante] += modelo.qtd_chamados; // Soma para o fabricante
            tempModelos[modelo.nome] = (tempModelos[modelo.nome] || 0) + modelo.qtd_chamados; // Soma para o modelo
        });
    });

    for (const fab in tempFabricantes) {
        fabricantesData.push({
            fabricante: fab,
            qtd_chamados: tempFabricantes[fab]
        });
    }

    for (const modelo in tempModelos) {
        modelosData.push({
            modelo: modelo,
            qtd_chamados: tempModelos[modelo]
        });
    }
    // FIM DOS DADOS DE EXEMPLO/AGREGAÇÃO


    // Cores para os gráficos (pode expandir ou usar uma paleta mais complexa)
    const backgroundColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#A1F0D5', '#D2B4DE', '#F5CBA7', '#ABEBC6', '#AED6F1', '#F5B7B1'
    ];
    const borderColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#A1F0D5', '#D2B4DE', '#F5CBA7', '#ABEBC6', '#AED6F1', '#F5B7B1'
    ];

    // --- GRÁFICO DE FABRICANTES ---
    const ctxFabricantes = document.getElementById('fabricantesChart').getContext('2d');
    new Chart(ctxFabricantes, {
        type: 'pie',
        data: {
            labels: fabricantesData.map(item => item.fabricante),
            datasets: [{
                data: fabricantesData.map(item => item.qtd_chamados),
                backgroundColor: backgroundColors.slice(0, fabricantesData.length),
                borderColor: borderColors.slice(0, fabricantesData.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.raw + ' chamado(s)';
                            return label;
                        }
                    }
                }
            }
        }
    });

    // --- GRÁFICO DE MODELOS ---
    const ctxModelos = document.getElementById('modelosChart').getContext('2d');
    new Chart(ctxModelos, {
        type: 'pie',
        data: {
            labels: modelosData.map(item => item.modelo),
            datasets: [{
                data: modelosData.map(item => item.qtd_chamados),
                backgroundColor: backgroundColors.slice(0, modelosData.length), // Reutiliza cores
                borderColor: borderColors.slice(0, modelosData.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.raw + ' chamado(s)';
                            return label;
                        }
                    }
                }
            }
        }
    });

    // --- Lógica Existente para a Árvore de Detalhamento ---
    const container = document.getElementById('tree-container');

    dadosChamados.forEach(fab => {
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
    /* Estilos existentes */
    .solicitar-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
    }

    h2 {
        font-size: 26px;
        margin: 0 0 15px; /* Adicionado margem para separar do h3 */
        text-align: center;
    }

    .fade-in {
        animation: fadeIn .6s ease-in-out;
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

    /* Estilos para as novas seções de gráficos */
    .chart-section {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px; /* Espaçamento entre os gráficos e a árvore */
        text-align: center;
    }

    .chart-section h3 {
        font-size: 22px;
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
    }

    /* Para garantir que o canvas seja responsivo */
    canvas {
        max-width: 100%;
        height: auto !important; /* Essencial para responsividade do Chart.js */
        margin: 0 auto;
        display: block; /* Centra o canvas */
    }

    /* Estilos da árvore de detalhamento */
    #tree-container {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-top: 20px; /* Adicionado espaçamento superior */
    }

    details summary {
        font-size: 18px;
        cursor: pointer;
        padding: 10px 15px; /* Ajustado padding */
        background: #1976d2;
        color: white;
        border-radius: 8px; /* Ajustado border-radius */
        margin-bottom: 8px; /* Ajustado margin-bottom */
        transition: background-color 0.3s ease;
    }

    details summary:hover {
        background-color: #115293; /* Cor de hover mais escura */
    }

    ul {
        list-style-type: disc;
        padding-left: 25px; /* Ajustado padding */
        margin-top: 10px;
        margin-bottom: 10px;
    }

    li {
        margin: 6px 0; /* Ajustado margem */
        color: #555;
    }

    /* Botão Voltar */
    .btn-voltar {
        margin-top: 20px;
        background: #2196f3;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: .3s;
    }

    .btn-voltar:hover {
        background: #1976d2;
        transform: translateY(-2px);
    }
</style>

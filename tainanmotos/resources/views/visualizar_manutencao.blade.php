@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="gerenciar-container fade-in">
    <h2>Visualizar Manutenções</h2>
    <p>Consulte abaixo as manutenções registradas no sistema.</p>

    <div class="form-group search-container">
        <input type="text" id="search" name="search" placeholder="Buscar...">
        <select id="search-type" name="search-type">
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="nome">Nome do Cliente</option>
            <option value="status">Status</option>
        </select>
    </div>

    <table class="manutencao-table">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Nome do Cliente</th>
                <th>Data de Abertura</th>
                <th>Status</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servicos as $servico)
            <tr
                data-id="{{ $servico->codigo }}"
                data-modelo="{{ $servico->moto->modelo->nome ?? '' }}"
                data-marca="{{ $servico->moto->modelo->fabricante->nome ?? '' }}"
                data-nome-cliente="{{ $servico->moto->usuario->nome ?? '' }}"
                data-status="{{ match($servico->situacao){1=>'pendente',2=>'em andamento',3=>'concluído',default=>''} }}"
            >
                <td>{{ $servico->moto->modelo->nome ?? '-' }}</td>
                <td>{{ $servico->moto->modelo->fabricante->nome ?? '-' }}</td>
                <td>{{ $servico->moto->usuario->nome ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d/m/Y') }}</td>
                <td>
                    @switch($servico->situacao)
                        @case(1)
                            Pendente
                            @break
                        @case(2)
                            Em andamento
                            @break
                        @case(3)
                            Concluído
                            @break
                        @default
                            -
                    @endswitch
                </td>
                <td>
                    <a href="#" class="btn-visualizar" data-id="{{ $servico->codigo }}">
                        <i class="fas fa-search"></i> Ver Detalhes
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Nenhuma manutenção encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
</div>

<!-- Modal Detalhes -->
<div id="modalDetalhes" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3>Detalhes da Manutenção</h3>
        <form class="modal-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="modal_data_abertura">Data Abertura</label>
                    <input type="date" id="modal_data_abertura" name="data_abertura" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_situacao">Situação</label>
                    <input type="text" id="modal_situacao" name="situacao" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_valor">Valor Total</label>
                    <input type="text" id="modal_valor" name="valor" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="modal_fabricante_moto">Fabricante</label>
                    <input id="modal_fabricante_moto" name="fabricante_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_modelo_moto">Modelo</label>
                    <input id="modal_modelo_moto" name="modelo_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_placa_moto">Placa</label>
                    <input id="modal_placa_moto" name="placa_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_ano_moto">Ano</label>
                    <input id="modal_ano_moto" name="ano_moto" readonly>
                </div>
                <div class="form-group">
                    <label for="modal_quilometragem">Quilometragem</label>
                    <input id="modal_quilometragem" name="quilometragem" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="modal_descricao">Descrição da Manutenção</label>
                    <textarea id="modal_descricao" name="descricao" rows="6" readonly style="background:#f5f5f5;"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="modal_mao_obra_adicionada">Mão de Obra Registrada</label>
                    <ul id="modal_mao_obra_adicionada" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="modal_pecas_adicionadas">Peças Registradas</label>
                    <ul id="modal_pecas_adicionadas" style="background:#f5f5f5;padding:10px;border-radius:8px;list-style-type:disc;">
                        <li><em>Carregando...</em></li>
                    </ul>
                </div>
            </div>

            <div class="form-row" style="justify-content:flex-end;">
                <button type="button" class="btn-visualizar" onclick="gerarPdfManutencao()" style="background:#1976d2; color: white;">
                    <i class="fas fa-file-pdf"></i> Gerar PDF
                </button>
                <button type="button" class="btn-voltar" onclick="fecharModal()">Fechar</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
{{-- SweetAlert2 para alertas --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- jsPDF para geração de PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
{{-- jsPDF AutoTable para tabelas (opcional, mas recomendado para listas) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


<script>
    // Referência global para os dados da manutenção atualmente aberta no modal
    let currentMaintenanceData = null;

    // Função para fechar o modal
    function fecharModal() {
        document.getElementById("modalDetalhes").style.display = "none";
        currentMaintenanceData = null; // Limpa os dados ao fechar
    }

    // Função para mostrar o modal
    function mostrarModal() {
        document.getElementById("modalDetalhes").style.display = "flex";
    }

    // Adiciona o event listener para os botões "Ver Detalhes"
    document.addEventListener('DOMContentLoaded', () => {
        const visualizarBtns = document.querySelectorAll('.btn-visualizar');
        visualizarBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idServico = this.dataset.id;

                // Define o conteúdo inicial para "Carregando..."
                document.getElementById("modal_mao_obra_adicionada").innerHTML = '<li><em>Carregando...</em></li>';
                document.getElementById("modal_pecas_adicionadas").innerHTML = '<li><em>Carregando...</em></li>';

                fetch(`/servico/${idServico}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok ' + res.statusText);
                        }
                        return res.json();
                    })
                    .then(data => {
                        currentMaintenanceData = data; // Armazena os dados para uso futuro (ex: PDF)

                        // Preenche os campos de texto do modal
                        document.getElementById("modal_data_abertura").value = data.data_abertura;
                        document.getElementById("modal_situacao").value = {
                            1: "Pendente",
                            2: "Em andamento",
                            3: "Concluído"
                        } [data.situacao] ?? "-";
                        document.getElementById("modal_fabricante_moto").value = data.moto.modelo.fabricante.nome ?? '-';
                        document.getElementById("modal_modelo_moto").value = data.moto.modelo.nome ?? '-';
                        document.getElementById("modal_placa_moto").value = data.moto.placa ?? '-';
                        document.getElementById("modal_ano_moto").value = data.moto.ano ?? '-';
                        document.getElementById("modal_quilometragem").value = data.quilometragem ?? '-';
                        document.getElementById("modal_descricao").value = data.descricao_manutencao ?? data.descricao ?? '';
                        document.getElementById("modal_valor").value = `R$ ${parseFloat(data.valor).toFixed(2).replace('.', ',')}`;

                        // Preenche a lista de Mão de Obra
                        const ulMaoObra = document.getElementById("modal_mao_obra_adicionada");
                        ulMaoObra.innerHTML = ''; // Limpa o "Carregando..."
                        if (data.maos_obra && data.maos_obra.length > 0) {
                            data.maos_obra.forEach(item => {
                                const li = document.createElement('li');
                                li.textContent = `${item.nome} - R$ ${parseFloat(item.valor).toFixed(2).replace('.', ',')}`;
                                ulMaoObra.appendChild(li);
                            });
                        } else {
                            ulMaoObra.innerHTML = '<li><em>Nenhuma mão de obra registrada.</em></li>';
                        }

                        // Preenche a lista de Peças
                        const ulPecas = document.getElementById("modal_pecas_adicionadas");
                        ulPecas.innerHTML = ''; // Limpa o "Carregando..."
                        if (data.pecas && data.pecas.length > 0) {
                            data.pecas.forEach(item => {
                                const li = document.createElement('li');
                                const quantidade = item.pivot ? (item.pivot.quantidade || 1) : 1;
                                li.textContent = `${item.nome} - R$ ${(parseFloat(item.preco) * quantidade).toFixed(2).replace('.', ',')} (x${quantidade})`;
                                ulPecas.appendChild(li);
                            });
                        } else {
                            ulPecas.innerHTML = '<li><em>Nenhuma peça registrada.</em></li>';
                        }

                        // Exibe o modal após preencher todos os dados
                        mostrarModal();
                    })
                    .catch(err => {
                        console.error("Erro ao buscar detalhes da manutenção:", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Não foi possível carregar os detalhes da manutenção.',
                            confirmButtonText: 'OK'
                        });
                        document.getElementById("modal_mao_obra_adicionada").innerHTML = '<li><em>Erro ao carregar mão de obra.</em></li>';
                        document.getElementById("modal_pecas_adicionadas").innerHTML = '<li><em>Erro ao carregar peças.</em></li>';
                    });
            });
        });
    });

    // Função para gerar o PDF
    function gerarPdfManutencao() {
        if (!currentMaintenanceData) {
            Swal.fire({
                icon: 'warning',
                title: 'Nenhum dado!',
                text: 'Por favor, selecione uma manutenção para visualizar os detalhes antes de gerar o PDF.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        let y = 20;
        const margin = 10;
        const lineHeight = 7;
        const titleLineHeight = 10;
        const subtitleLineHeight = 8;

        doc.setFontSize(22);
        doc.text("Detalhes da Manutenção", doc.internal.pageSize.width / 2, y, { align: 'center' });
        y += titleLineHeight;

        doc.setFontSize(12);
        doc.text(`ID do Serviço: ${currentMaintenanceData.codigo}`, margin, y);
        y += lineHeight;
        doc.text(`Data de Abertura: ${currentMaintenanceData.data_abertura ? new Date(currentMaintenanceData.data_abertura).toLocaleDateString('pt-BR') : '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Situação: ${({1: "Pendente", 2: "Em andamento", 3: "Concluído"})[currentMaintenanceData.situacao] ?? '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Valor Total: ${parseFloat(currentMaintenanceData.valor).toFixed(2).replace('.', ',')}`, margin, y);
        y += titleLineHeight; // Espaço extra

        doc.setFontSize(16);
        doc.text("Dados da Moto:", margin, y);
        y += subtitleLineHeight;
        doc.setFontSize(12);
        doc.text(`Fabricante: ${currentMaintenanceData.moto.modelo.fabricante.nome ?? '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Modelo: ${currentMaintenanceData.moto.modelo.nome ?? '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Placa: ${currentMaintenanceData.moto.placa ?? '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Ano: ${currentMaintenanceData.moto.ano ?? '-'}`, margin, y);
        y += lineHeight;
        doc.text(`Quilometragem: ${currentMaintenanceData.quilometragem ?? '-'} km`, margin, y);
        y += titleLineHeight; // Espaço extra

        doc.setFontSize(16);
        doc.text("Descrição da Manutenção:", margin, y);
        y += subtitleLineHeight;
        doc.setFontSize(12);
        const descriptionLines = doc.splitTextToSize(currentMaintenanceData.descricao_manutencao ?? currentMaintenanceData.descricao ?? 'Nenhuma descrição.', doc.internal.pageSize.width - 2 * margin);
        doc.text(descriptionLines, margin, y);
        y += (descriptionLines.length * lineHeight) + titleLineHeight; // Espaço extra

        // Adicionar Mão de Obra
        if (currentMaintenanceData.maos_obra && currentMaintenanceData.maos_obra.length > 0) {
            doc.setFontSize(16);
            doc.text("Mão de Obra Registrada:", margin, y);
            y += subtitleLineHeight;
            const maoObraData = currentMaintenanceData.maos_obra.map(item => [
                item.nome,
                `R$ ${parseFloat(item.valor).toFixed(2).replace('.', ',')}`
            ]);
            doc.autoTable({
                startY: y,
                head: [['Nome', 'Valor']],
                body: maoObraData,
                margin: { left: margin, right: margin },
                styles: { fontSize: 10, cellPadding: 2, overflow: 'linebreak' },
                headStyles: { fillColor: [25, 118, 210], textColor: [255, 255, 255] }, // Azul do tema
                didDrawPage: function (data) {
                    y = data.cursor.y + lineHeight; // Atualiza a posição Y após a tabela
                }
            });
            y = doc.autoTable.previous.finalY + titleLineHeight;
        } else {
            doc.setFontSize(16);
            doc.text("Mão de Obra Registrada:", margin, y);
            y += subtitleLineHeight;
            doc.setFontSize(12);
            doc.text("Nenhuma mão de obra registrada.", margin, y);
            y += titleLineHeight;
        }


        // Adicionar Peças
        if (currentMaintenanceData.pecas && currentMaintenanceData.pecas.length > 0) {
            doc.setFontSize(16);
            doc.text("Peças Registradas:", margin, y);
            y += subtitleLineHeight;
            const pecasData = currentMaintenanceData.pecas.map(item => [
                item.nome,
                `R$ ${parseFloat(item.preco).toFixed(2).replace('.', ',')}`,
                item.pivot?.quantidade || 1,
                `R$ ${(parseFloat(item.preco) * (item.pivot?.quantidade || 1)).toFixed(2).replace('.', ',')}`
            ]);
            doc.autoTable({
                startY: y,
                head: [['Nome', 'Preço Unit.', 'Quant.', 'Total Item']],
                body: pecasData,
                margin: { left: margin, right: margin },
                styles: { fontSize: 10, cellPadding: 2, overflow: 'linebreak' },
                headStyles: { fillColor: [25, 118, 210], textColor: [255, 255, 255] }, // Azul do tema
            });
        } else {
            doc.setFontSize(16);
            doc.text("Peças Registradas:", margin, y);
            y += subtitleLineHeight;
            doc.setFontSize(12);
            doc.text("Nenhuma peça registrada.", margin, y);
        }

        // Salva o PDF
        doc.save(`manutencao_${currentMaintenanceData.codigo}.pdf`);
    }


    // Funções de filtro de busca (mantidas)
    document.getElementById('search').addEventListener('keyup', filterTable);
    document.getElementById('search-type').addEventListener('change', filterTable);

    function filterTable() {
        const searchText = document.getElementById('search').value.toLowerCase();
        const searchType = document.getElementById('search-type').value;
        const rows = document.querySelectorAll('.manutencao-table tbody tr');

        rows.forEach(row => {
            let cellContent = '';
            if (searchType === 'modelo') {
                cellContent = row.getAttribute('data-modelo').toLowerCase();
            } else if (searchType === 'marca') {
                cellContent = row.getAttribute('data-marca').toLowerCase();
            } else if (searchType === 'nome') {
                cellContent = row.getAttribute('data-nome-cliente').toLowerCase();
            } else if (searchType === 'status') {
                cellContent = row.getAttribute('data-status').toLowerCase();
            }

            if (cellContent.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<style>
    /* Estilos CSS (mantidos os mesmos do seu arquivo original) */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        margin: 0
    }

    .gerenciar-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1)
    }

    h2 {
        font-size: 26px;
        margin: 0 0 5px
    }

    .fade-in {
        animation: fadeIn .6s ease-in-out
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    /* ---------- FILTRO ---------- */
    .search-container {
        margin: 20px 0;
        display: flex;
        gap: 10px;
        flex-wrap: wrap
    }

    .search-container input,
    .search-container select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: .3s
    }

    .search-container input:focus,
    .search-container select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, .3);
        outline: none
    }

    /* ---------- TABELA ---------- */
    .manutencao-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden
    }

    .manutencao-table th,
    .manutencao-table td {
        padding: 12px 15px;
        font-size: 14px;
        border-bottom: 1px solid #eee;
        text-align: left
    }

    .manutencao-table th {
        background: #f0f2f5;
        font-weight: bold
    }

    .manutencao-table tr:hover {
        background: #f9f9f9
    }

    /* ---------- BOTÕES ---------- */
    .btn-visualizar,
    .btn-voltar,
    .btn-concluir {
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: .3s
    }

    .btn-visualizar {
        background: #ffe633;
        color: #333
    }

    .btn-visualizar:hover {
        background: #ffdd00;
        transform: translateY(-2px)
    }

    .btn-concluir {
        background: #4caf50;
        color: #fff
    }

    .btn-concluir:hover {
        background: #43a047;
        transform: translateY(-2px)
    }

    .btn-voltar {
        margin-top: 20px;
        background: #2196f3;
        color: #fff
    }

    .btn-voltar:hover {
        background: #1976d2;
        transform: translateY(-2px)
    }

    /* ---------- MODAL OVERLAY ---------- */
    .modal-overlay {
        position: fixed;
        inset: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, .5);
        z-index: 999
    }

    /* ---------- MODAL CONTENT ---------- */
    .modal-overlay .modal-content {
        width: 90vw !important;
        /* ocupa 90% da viewport */
        max-width: 1000px !important;
        /* limite para monitores grandes */
        max-height: 90vh;
        /* evita estourar a altura */
        overflow-y: auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
        animation: fadeIn .3s;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #555
    }

    /* ---------- FORM NO MODAL ---------- */
    .modal-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 20px
    }

    .modal-form .form-group {
        display: flex;
        flex-direction: column;
        width: 100%
    }

    .modal-form label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333
    }

    .modal-form input,
    .modal-form textarea,
    .modal-form select {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #fff;
        transition: border-color .3s
    }

    .modal-form input:focus,
    .modal-form textarea:focus,
    .modal-form select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, .3);
        outline: none
    }

    /* ---------- BOTÕES NO MODAL ---------- */
    .btn-plus {
        padding: 10px 12px;
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: .3s
    }

    .btn-plus:hover {
        background: #115293
    }

    .btn-enviar {
        padding: 12px 20px;
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .3s
    }

    .btn-enviar:hover {
        background: #115293;
        transform: translateY(-2px)
    }

    /* ---------- LISTAS DE MÃO DE OBRA E PEÇAS ---------- */
    #mao_obra_adicionada li,
    #pecas_adicionadas li {
        padding: 5px 0;
        border-bottom: 1px dashed #eee;
    }
    #mao_obra_adicionada li:last-child,
    #pecas_adicionadas li:last-child {
        border-bottom: none;
    }
</style>

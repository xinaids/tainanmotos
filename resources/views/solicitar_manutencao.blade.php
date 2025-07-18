@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="solicitar-container fade-in">
    <h2>Solicitar Manutenção</h2>
    <form action="{{ route('manutencao.store') }}" method="POST">
        @csrf

        <!-- Placa da moto -->
        <div class="form-group">
            <label for="placa">Placa da Moto <span class="required-asterisk">*</span></label>
            <input type="text" id="placa" name="placa" required placeholder="ABC-1234" maxlength="8">
        </div>

        <!-- Marca da moto -->
        <div class="form-group">
            <label for="marca">Marca da Moto <span class="required-asterisk">*</span></label>
            <select id="marca" name="marca" required>
                <option value="" disabled selected>Selecione uma marca</option>
                @foreach ($marcas as $marca)
                <option value="{{ $marca->codigo }}">{{ $marca->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Modelo da moto -->
        <div class="form-group">
            <label for="modelo">Modelo da Moto <span class="required-asterisk">*</span></label>
            <select id="modelo" name="modelo" required disabled>
                <option value="" disabled selected>Selecione uma marca primeiro</option>
                @foreach ($modelos as $modelo)
                <option value="{{ $modelo->codigo }}" data-marca="{{ $modelo->cod_fabricante }}">
                    {{ $modelo->nome }} ({{ $modelo->fabricante->nome }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Cor da moto -->
        <div class="form-group">
            <label for="cor">Cor da Moto <span class="required-asterisk">*</span></label>
            <input type="text" id="cor" name="cor" required>
        </div>


        <!-- Quilometragem -->
        <div class="form-group">
            <label for="quilometragem">Quilometragem <span class="required-asterisk">*</span></label>
            <input type="number" id="quilometragem" name="quilometragem" required min="0" max="999999" placeholder="Até 999.999 km">
        </div>



        <!-- Ano -->
        <div class="form-group">
            <label for="ano">Ano <span class="required-asterisk">*</span></label>
            <input type="number" id="ano" name="ano" required>
        </div>

        <!-- Descrição -->

        <div class="form-group">
            <label for="descricao">Descrição <span class="required-asterisk">*</span></label>
            <textarea id="descricao" name="descricao" rows="4" required placeholder="Insira as informações referente à manutenção da moto"></textarea>
        </div>


        <button type="submit" class="btn-submit"><i class="fas fa-wrench"></i> Solicitar Manutenção</button>
    </form>


    <!-- Botão de Voltar -->
    <a href="{{ route('dashboard') }}" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
</div>
@endsection

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .solicitar-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 25px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
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
        text-align: left;
    }

    label {
        display: block;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .required-asterisk {
        color: red;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: border-color 0.3s;
        box-sizing: border-box;
        resize: none;
    }

    textarea {
        min-height: 100px;
        overflow-y: auto;
    }

    input:focus,
    textarea:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s, transform 0.2s;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background-color: #115293;
        transform: translateY(-2px);
    }

    .btn-voltar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 15px;
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

    select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: border-color 0.3s;
        box-sizing: border-box;
        background-color: white;
        appearance: none;
    }

    select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 5px rgba(25, 118, 210, 0.3);
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const placaInput = document.getElementById('placa');

        placaInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            if (value.length > 3) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }

            e.target.value = value.slice(0, 8);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quilometragemInput = document.getElementById('quilometragem');

        quilometragemInput.addEventListener('input', function() {
            const max = 999999;
            let value = parseInt(this.value);

            if (value > max) {
                this.value = max;
            } else if (value < 0 || isNaN(value)) {
                this.value = '';
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');
    const allModelos = Array.from(modeloSelect.options);

    marcaSelect.addEventListener('change', function () {
        const marcaSelecionada = this.value;

        // Limpa e reseta o select de modelo
        modeloSelect.innerHTML = '';
        modeloSelect.disabled = true;

        const modelosFiltrados = allModelos.filter(option => {
            return option.dataset.marca === marcaSelecionada;
        });

        if (modelosFiltrados.length > 0) {
            modeloSelect.disabled = false;

            // Adiciona opção padrão
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Selecione um modelo';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            modeloSelect.appendChild(defaultOption);

            modelosFiltrados.forEach(opt => {
                modeloSelect.appendChild(opt.cloneNode(true));
            });
        } else {
            const noOption = document.createElement('option');
            noOption.textContent = 'Nenhum modelo disponível';
            noOption.disabled = true;
            modeloSelect.appendChild(noOption);
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const placaInput = document.getElementById('placa');
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');
    const corInput = document.getElementById('cor');
    const anoInput = document.getElementById('ano');

    placaInput.addEventListener('blur', function () {
        const placa = this.value.trim().toUpperCase();
        if (placa.length >= 7) {
            fetch(`/moto/por-placa/${placa}`)
                .then(response => {
                    if (!response.ok) throw new Error('Moto não encontrada');
                    return response.json();
                })
                .then(data => {
                    corInput.value = data.cor;
                    anoInput.value = data.ano;

                    // Define a marca
                    marcaSelect.value = data.marca;
                    marcaSelect.dispatchEvent(new Event('change'));

                    // Aguarda um pouco para popular os modelos
                    setTimeout(() => {
                        modeloSelect.value = data.modelo;
                    }, 200);
                })
                .catch(() => {
                    corInput.value = '';
                    anoInput.value = '';
                    modeloSelect.value = '';
                });
        }
    });
});
</script>


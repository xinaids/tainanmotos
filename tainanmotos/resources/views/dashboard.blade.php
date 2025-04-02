@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="card-container">
        <!-- Card de Solicitar Manutenção -->
        <div class="card">
            <div class="card-content">
                <i class="fas fa-tools icon"></i>
                <h3>Solicitar Manutenção</h3>
                <p>Realize uma solicitação de manutenção para sua moto.</p>
                <a href="{{ url('/solicitar-manutencao') }}" class="btn-card">Acessar</a>
            </div>
        </div>

        <!-- Card de Visualizar Manutenção -->
        <div class="card">
            <div class="card-content">
                <i class="fas fa-eye icon"></i>
                <h3>Visualizar Manutenção</h3>
                <p>Veja o status das manutenções realizadas.</p>
                <a href="{{ url('/visualizar-manutencao') }}" class="btn-card">Acessar</a>
            </div>
        </div>

        <!-- Card de Gerenciar Manutenção -->
        <div class="card">
            <div class="card-content">
                <i class="fas fa-clipboard-list icon"></i>
                <h3>Gerenciar Manutenção</h3>
                <p>Gerencie suas manutenções em aberto.</p>
                <!-- Corrigido para a rota nomeada 'gerenciar.manutencao' -->
                <a href="{{ route('gerenciar.manutencao') }}" class="btn-card">Acessar</a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Fundo da página */
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

/* Container principal do dashboard */
.dashboard-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
    padding: 20px;
    flex-direction: column;
}

h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

/* Container dos cards */
.card-container {
    display: flex;
    justify-content: space-around;
    width: 100%;
    max-width: 900px;
    gap: 20px;
}

/* Estilo de cada card */
.card {
    background: #fff;
    padding: 20px;
    width: 30%;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-10px);
}

/* Ícones */
.icon {
    font-size: 40px;
    color:rgb(18, 31, 46);
    margin-bottom: 10px;
}

/* Estilo do conteúdo do card */
.card-content h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #333;
}

.card-content p {
    font-size: 14px;
    color: #777;
    margin-bottom: 20px;
}

/* Botão dos cards */
.btn-card {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-card:hover {
    background-color: #0056b3;
}
</style>

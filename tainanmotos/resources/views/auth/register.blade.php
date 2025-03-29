@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="register-box">
        <h2>Cadastro</h2>
        <form action="#" method="POST">
            <div class="input-group">
                <label for="name">Nome Completo:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="password_confirmation">Confirmar Senha:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn-register">Cadastrar</button>
        </form>
        <p class="login-text">Já tem uma conta? <a href="{{ route('login') }}" class="login-link">Faça login aqui</a></p>
    </div>
</div>
@endsection

<style>
/* Fundo da página */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6e7c87, #2f3c45);
    margin: 0;
    padding: 0;
}

/* Container principal do registro */
.register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}

/* Caixa do registro */
.register-box {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Título do cadastro */
h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

/* Estilo dos campos de input */
.input-group {
    margin-bottom: 20px;
    text-align: left;
}

/* Estilo do label */
label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

/* Estilo do input */
input {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
}

/* Botão de cadastro */
.btn-register {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-register:hover {
    background-color: #0056b3;
}

/* Texto para login */
.login-text {
    margin-top: 20px;
    font-size: 14px;
    color: #333;
}

.login-link {
    color: #007bff;
    text-decoration: none;
}

.login-link:hover {
    text-decoration: underline;
}
</style>

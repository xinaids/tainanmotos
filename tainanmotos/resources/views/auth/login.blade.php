@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <form action="/dashboard" method="GET">
    <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-login">Entrar</button>
        </form>

        <a href="{{ route('password.request') }}" class="forgot-password">Esqueci minha senha</a>
        <p class="signup-text">Ainda não tem uma conta? <a href="{{ route('register') }}" class="signup-link">Cadastre-se aqui</a></p>
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

/* Container principal do login */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}

/* Caixa do login */
.login-box {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Título do login */
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

/* Botão de login */
.btn-login {
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

.btn-login:hover {
    background-color: #0056b3;
}

/* Estilo do link de esqueci a senha */
.forgot-password {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
    transition: text-decoration 0.3s;
}

.forgot-password:hover {
    text-decoration: underline;
}

/* Texto para cadastro */
.signup-text {
    margin-top: 20px;
    font-size: 14px;
    color: #333;
}

.signup-link {
    color: #007bff;
    text-decoration: none;
}

.signup-link:hover {
    text-decoration: underline;
}
</style>

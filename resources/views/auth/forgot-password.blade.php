@extends('layouts.app')

@section('content')
<div class="forgot-password-container">
    <div class="forgot-password-box">
        <h2>Esqueci Minha Senha</h2>
        <form action="#" method="POST">
            <div class="input-group">
                <label for="email">Digite seu email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn-reset">Enviar Link de Recuperação</button>
        </form>
        <p class="back-to-login">Lembrei minha senha? <a href="{{ route('login') }}" class="login-link">Voltar para o login</a></p>
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

/* Container principal da tela de recuperação */
.forgot-password-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}

/* Caixa da tela de recuperação */
.forgot-password-box {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Título da tela de recuperação */
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

/* Botão de envio de link de recuperação */
.btn-reset {
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

.btn-reset:hover {
    background-color: #0056b3;
}

/* Texto para voltar ao login */
.back-to-login {
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

@extends('layouts.app')

@section('content')
<div class="login-container">
    <h2>Login</h2>
    <form action="#" method="POST">
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
    <a href="#" class="forgot-password">Esqueci minha senha</a>
</div>
@endsection

<style>
.login-container {
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}
.input-group {
    margin-bottom: 15px;
    text-align: left;
}
label {
    display: block;
    font-weight: bold;
}
input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.btn-login {
    width: 100%;
    padding: 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.btn-login:hover {
    background: #0056b3;
}
.forgot-password {
    display: block;
    margin-top: 10px;
    color: #007bff;
    text-decoration: none;
}
.forgot-password:hover {
    text-decoration: underline;
}
</style>

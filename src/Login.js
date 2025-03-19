import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import './Login.css';

function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Login:', username, 'Senha:', password);
    // Aqui você pode adicionar a lógica de autenticação
    // Se o login for bem-sucedido, redirecione para o dashboard
    navigate('/dashboard');
  };

  return (
    <div className="container">
      <h2 className="title">Bem-vindo</h2>
      <form onSubmit={handleSubmit} className="form">
        <div className="input-group">
          <label htmlFor="username" className="label">Login</label>
          <input
            type="text"
            id="username"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            className="input"
            placeholder="Digite seu login"
            required
          />
        </div>
        <div className="input-group">
          <label htmlFor="password" className="label">Senha</label>
          <input
            type="password"
            id="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="input"
            placeholder="Digite sua senha"
            required
          />
        </div>
        <button type="submit" className="button">
          Entrar
        </button>
      </form>
      <p className="footer">
        Não tem uma conta?{' '}
        <a href="/criar-conta" className="link">
          Crie uma conta
        </a>
      </p>
    </div>
  );
}

export default Login;
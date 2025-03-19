import React, { useState } from 'react';
import './CriarConta.css';

function CriarConta() {
  const [nomeCompleto, setNomeCompleto] = useState('');
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [cpf, setCpf] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Nome:', nomeCompleto, 'Email:', email, 'Senha:', senha, 'CPF:', cpf);
  };

  return (
    <div className="container">
      <h2 className="title">Criar Conta</h2>
      <form onSubmit={handleSubmit} className="form">
        <div className="input-group">
          <label htmlFor="nomeCompleto" className="label">Nome Completo</label>
          <input
            type="text"
            id="nomeCompleto"
            value={nomeCompleto}
            onChange={(e) => setNomeCompleto(e.target.value)}
            className="input"
            placeholder="Digite seu nome completo"
            required
          />
        </div>
        <div className="input-group">
          <label htmlFor="email" className="label">Email</label>
          <input
            type="email"
            id="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="input"
            placeholder="Digite seu email"
            required
          />
        </div>
        <div className="input-group">
          <label htmlFor="senha" className="label">Senha</label>
          <input
            type="password"
            id="senha"
            value={senha}
            onChange={(e) => setSenha(e.target.value)}
            className="input"
            placeholder="Digite sua senha"
            required
          />
        </div>
        <div className="input-group">
          <label htmlFor="cpf" className="label">CPF</label>
          <input
            type="text"
            id="cpf"
            value={cpf}
            onChange={(e) => setCpf(e.target.value)}
            className="input"
            placeholder="Digite seu CPF (somente números)"
            required
          />
        </div>
        <button type="submit" className="button">
          Criar Conta
        </button>
      </form>
      <p className="footer">
        Já tem uma conta?{' '}
        <a href="/login" className="link">
          Faça login
        </a>
      </p>
    </div>
  );
}

export default CriarConta;
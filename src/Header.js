import React from 'react';
import { useNavigate } from 'react-router-dom';
import './Header.css';

function Header({ username }) {
  const navigate = useNavigate();

  const handleLogout = () => {
    // Aqui você pode adicionar lógica para deslogar (ex.: limpar token)
    navigate('/login');
  };

  return (
    <header className="header">
      <div className="header-left">
        <span className="motorcycle-icon">🏍️</span>
        <h1 className="app-name">Tainan Motos</h1>
      </div>
      <div className="header-right">
        <span className="username">Olá, {username || 'Usuário'}</span>
        <button className="settings-button" title="Configurações">
          ⚙️
        </button>
        <button className="logout-button" onClick={handleLogout}>
          Sair
        </button>
      </div>
    </header>
  );
}

export default Header;
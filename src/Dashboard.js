import React from "react";
import { useNavigate } from "react-router-dom";
import Header from "./Header";
import "./Dashboard.css";

function Dashboard() {
  const navigate = useNavigate();
  const username = "Mateus"; // Exemplo fixo; substitua por lógica de autenticação

  return (
    <div>
      <Header username={username} />
      <div className="dashboard-container">
        <h1 className="dashboard-title">Bem-vindo ao Painel</h1>
        <div className="cards-container">
          <div className="card">
            <h2 className="card-title">Solicitar Manutenção</h2>
            <p className="card-description">Solicite uma nova manutenção para sua moto.</p>
            <button className="card-button" onClick={() => navigate("/solicitar-manutencao")}>
              Acessar
            </button>
          </div>
          <div className="card">
            <h2 className="card-title">Visualizar Manutenções</h2>
            <p className="card-description">Veja o histórico de manutenções realizadas.</p>
            <button className="card-button" onClick={() => navigate("/visualizar-manutencoes")}>
              Acessar
            </button>
          </div>
          <div className="card">
            <h2 className="card-title">Gerenciar Manutenções</h2>
            <p className="card-description">Gerencie as manutenções em andamento.</p>
            <button className="card-button">Acessar</button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;

import React from "react";
import { useNavigate } from "react-router-dom";
import "./VisualizarManutencoes.css";

function VisualizarManutencoes() {
  const navigate = useNavigate();

  // Dados fictícios (pode ser substituído por uma API futuramente)
  const manutencoes = [
    {
      id: 1,
      modelo: "CG 160",
      marca: "Honda",
      cor: "Preta",
      placa: "ABC-1234",
      descricao: "Troca de óleo e revisão geral.",
      status: "Em andamento", // Status da manutenção
      dataAtualizacao: "2025-03-20", // Data de atualização
    },
    {
      id: 2,
      modelo: "Fazer 250",
      marca: "Yamaha",
      cor: "Azul",
      placa: "XYZ-5678",
      descricao: "Correia danificada, necessita substituição.",
      status: "Concluída", // Status da manutenção
      dataAtualizacao: "2025-03-18", // Data de atualização
    },
  ];

  return (
    <div className="container">
      <h2 className="title">Visualizar Manutenções</h2>
      <div className="manutencao-list">
        {manutencoes.length > 0 ? (
          manutencoes.map((manutencao) => (
            <div key={manutencao.id} className="manutencao-card">
              <p><strong>Modelo:</strong> {manutencao.modelo}</p>
              <p><strong>Marca:</strong> {manutencao.marca}</p>
              <p><strong>Cor:</strong> {manutencao.cor}</p>
              <p><strong>Placa:</strong> {manutencao.placa}</p>
              <p><strong>Descrição:</strong> {manutencao.descricao}</p>
              <p><strong>Status:</strong> {manutencao.status}</p>
              <p><strong>Data de Atualização:</strong> {new Date(manutencao.dataAtualizacao).toLocaleDateString()}</p>
            </div>
          ))
        ) : (
          <p>Nenhuma manutenção encontrada.</p>
        )}
      </div>
      <button onClick={() => navigate("/dashboard")} className="button">
        Voltar
      </button>
    </div>
  );
}

export default VisualizarManutencoes;

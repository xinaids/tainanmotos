import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./VisualizarManutencoes.css";

function VisualizarManutencoes() {
  const navigate = useNavigate();
  const [searchTerm, setSearchTerm] = useState("");

  // Dados fictícios (pode ser substituído por uma API futuramente)
  const manutencoes = [
    {
      id: 1,
      modelo: "CG 160",
      marca: "Honda",
      cor: "Preta",
      placa: "ABC-1234",
      descricao: "Troca de óleo e revisão geral.",
      status: "Em andamento",
      dataAtualizacao: "2025-03-20",
    },
    {
      id: 2,
      modelo: "Fazer 250",
      marca: "Yamaha",
      cor: "Azul",
      placa: "XYZ-5678",
      descricao: "Correia danificada, necessita substituição.",
      status: "Concluída",
      dataAtualizacao: "2025-03-18",
    },
  ];

  // Filtragem baseada na barra de pesquisa
  const manutencoesFiltradas = manutencoes.filter((manutencao) =>
    `${manutencao.modelo} ${manutencao.marca} ${manutencao.placa}`
      .toLowerCase()
      .includes(searchTerm.toLowerCase())
  );

  return (
    <div className="container">
      <h2 className="title">Visualizar Manutenções</h2>

      {/* Barra de Pesquisa */}
      <input
        type="text"
        placeholder="Pesquisar por modelo, marca ou placa..."
        className="search-bar"
        value={searchTerm}
        onChange={(e) => setSearchTerm(e.target.value)}
      />

      <div className="manutencao-list">
        {manutencoesFiltradas.length > 0 ? (
          manutencoesFiltradas.map((manutencao) => (
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
          <p className="no-results">Nenhuma manutenção encontrada.</p>
        )}
      </div>

      <button onClick={() => navigate("/dashboard")} className="button">
        Voltar
      </button>
    </div>
  );
}

export default VisualizarManutencoes;

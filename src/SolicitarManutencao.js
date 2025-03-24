import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./SolicitarManutencao.css";

function SolicitarManutencao() {
  const [modelo, setModelo] = useState("");
  const [marca, setMarca] = useState("");
  const [cor, setCor] = useState("");
  const [placa, setPlaca] = useState("");
  const [descricao, setDescricao] = useState("");
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!modelo || !marca || !cor || !placa || !descricao.trim()) {
      alert("Por favor, preencha todos os campos.");
      return;
    }

    alert("Solicitação enviada com sucesso!");

    // Aqui você pode adicionar a lógica para enviar a solicitação ao backend

    navigate("/dashboard");
  };

  return (
    <div className="container">
      <h2 className="title">Solicitar Manutenção</h2>
      <form onSubmit={handleSubmit} className="form">
        <div className="input-group">
          <label className="label">Modelo da Moto</label>
          <input
            type="text"
            value={modelo}
            onChange={(e) => setModelo(e.target.value)}
            className="input"
            placeholder="Digite o modelo da moto"
            required
          />
        </div>
        <div className="input-group">
          <label className="label">Marca da Moto</label>
          <input
            type="text"
            value={marca}
            onChange={(e) => setMarca(e.target.value)}
            className="input"
            placeholder="Digite a marca da moto"
            required
          />
        </div>
        <div className="input-group">
          <label className="label">Cor da Moto</label>
          <input
            type="text"
            value={cor}
            onChange={(e) => setCor(e.target.value)}
            className="input"
            placeholder="Digite a cor da moto"
            required
          />
        </div>
        <div className="input-group">
          <label className="label">Placa da Moto</label>
          <input
            type="text"
            value={placa}
            onChange={(e) => setPlaca(e.target.value)}
            className="input"
            placeholder="Digite a placa da moto"
            required
          />
        </div>
        <div className="input-group">
          <label className="label">Descrição do Problema</label>
          <textarea
            value={descricao}
            onChange={(e) => setDescricao(e.target.value)}
            className="input"
            placeholder="Descreva o problema"
            required
          />
        </div>
        <button type="submit" className="button">Enviar Solicitação</button>
      </form>
      <button onClick={() => navigate("/dashboard")} className="button">
        Voltar
      </button>
    </div>
  );
}

export default SolicitarManutencao;

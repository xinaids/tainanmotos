import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import './GerenciarManutencoes.css';

const mockManutencoes = [
  { id: 1, nome: 'João Silva', marca: 'Honda', modelo: 'CB 500', detalhes: 'Troca de óleo e revisão geral.' },
  { id: 2, nome: 'Maria Oliveira', marca: 'Yamaha', modelo: 'Fazer 250', detalhes: 'Troca de pastilhas de freio.' },
  { id: 3, nome: 'Carlos Souza', marca: 'Suzuki', modelo: 'V-Strom 650', detalhes: 'Ajuste na embreagem e lubrificação.' }
];

function GerenciarManutencoes() {
  const [manutencoes] = useState(mockManutencoes);
  const [detalhesAtuais, setDetalhesAtuais] = useState(null);
  const navigate = useNavigate();

  const abrirDetalhes = (detalhes) => {
    setDetalhesAtuais(detalhes);
  };

  const fecharPopup = () => {
    setDetalhesAtuais(null);
  };

  const voltarDashboard = () => {
    navigate('/dashboard');
  };

  return (
    <div className="gerenciar-container">
      <h2>Gerenciar Manutenções</h2>
      <table className="tabela-manutencoes">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          {manutencoes.map((manutencao) => (
            <tr key={manutencao.id}>
              <td>{manutencao.nome}</td>
              <td>{manutencao.marca}</td>
              <td>{manutencao.modelo}</td>
              <td>
                <button className="detalhes-button" onClick={() => abrirDetalhes(manutencao.detalhes)}>Ver Detalhes</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      <button className="voltar-button" onClick={voltarDashboard}>← Voltar</button>

      {detalhesAtuais && (
        <div className="popup">
          <div className="popup-content">
            <h3>Detalhes da Manutenção</h3>
            <p>{detalhesAtuais}</p>
            <button className="fechar-button" onClick={fecharPopup}>Fechar</button>
          </div>
        </div>
      )}
    </div>
  );
}

export default GerenciarManutencoes;

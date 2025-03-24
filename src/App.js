import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Login from "./Login";
import CriarConta from "./CriarConta";
import Dashboard from "./Dashboard";
import SolicitarManutencao from "./SolicitarManutencao";
import VisualizarManutencoes from "./VisualizarManutencoes";

function App() {
  return (
    <Router>
      <div className="App">
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/criar-conta" element={<CriarConta />} />
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/solicitar-manutencao" element={<SolicitarManutencao />} />
          <Route path="/visualizar-manutencoes" element={<VisualizarManutencoes />} />
          <Route path="/" element={<Login />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;

<header class="header">
  <div class="header-left">
    {{-- Substitui o texto "Tainan Motos" pela tag de imagem da logo --}}
    <a href="{{ route('dashboard') }}" class="logo-link">
        {{-- Use a URL da sua logo real aqui. Exemplo: asset('images/logo.png') --}}
        <img src="{{ asset('imagens/tainanlogo.png') }}" alt="Logo Tainan Motos" style="height: 40px; width: auto; border-radius: 5px;">
    </a>
  </div>

  <div class="header-center">
    <nav class="nav-links">

      <!-- Dropdown Manutenções (todos podem ver) -->
      <div class="dropdown">
        <div class="nav-link dropdown-toggle">
          <i class="fas fa-tools"></i> Manutenções
        </div>
        <div class="dropdown-menu">
          <a href="/solicitar-manutencao" class="dropdown-item">Solicitar</a>
          <a href="/visualizar-manutencao" class="dropdown-item">Visualizar</a>
          {{-- só mostra para quem NÃO é cliente (tipo 1) --}}
          @if(session('usuario') && session('usuario')->tipo != 1)
          <a href="/gerenciar-manutencao" class="dropdown-item">Gerenciar</a>
          @endif
        </div>
      </div>

      <!-- Apenas para tipo 2 (administrador) -->
      @if(session('usuario') && session('usuario')->tipo == 2)
      <!-- Dropdown Cadastro -->
      <div class="dropdown">
        <div class="nav-link dropdown-toggle">
          <i class="fas fa-plus"></i> Cadastro
        {</div>
        <div class="dropdown-menu">
          <a href="/cadastrar-fabricante" class="dropdown-item">Fabricante</a>
          <a href="/cadastrar-modelo" class="dropdown-item">Modelo</a>
          <a href="/cadastrar-peca" class="dropdown-item">Peça</a>
          <a href="/cadastrar-mao-de-obra" class="dropdown-item">Mão de Obra</a>
        </div>
      </div>

      <!-- Dropdown Consultas -->
      <div class="dropdown">
        <div class="nav-link dropdown-toggle">
          <i class="fas fa-search"></i> Consultas
        </div>
        <div class="dropdown-menu">
          <a href="/fabricantes" class="dropdown-item">Fabricantes</a>
          <a href="/modelos" class="dropdown-item">Modelos</a>
          <a href="/pecas" class="dropdown-item">Peças</a>
          <a href="/maodeobra" class="dropdown-item">Mão de Obra</a>
          <a href="/motos" class="dropdown-item">Motos</a>
        </div>
      </div>

      <!-- Relatórios -->
      <a href="/estatisticas" class="nav-link"><i class="fas fa-chart-bar"></i> Relatórios</a>
      @endif

    </nav>
  </div>

  <div class="header-right">
    @if(session('usuario'))
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Olá, {{ session('usuario')->nome }}</span>
    </div>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
      @csrf
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</button>
    </form>
    @else
    <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> Entrar</a>
    @endif
  </div>

  <style>
    .header {
      background: #1a202c;
      /* Darker background */
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header-left h1 {
      margin: 0;
      font-size: 28px;
    }

    .logo-link {
      text-decoration: none;
      color: #fff;
      font-weight: bold;
    }

    .logo-link img {
      height: 40px; /* Ajuste a altura da logo conforme necessário */
      width: auto;
      vertical-align: middle;
      border-radius: 5px; /* Mantém o raio de borda para a logo */
    }

    .header-center .nav-links {
      display: flex;
      gap: 25px;
    }

    .nav-link {
      color: #e2e8f0;
      text-decoration: none;
      font-size: 16px;
      padding: 8px 12px;
      border-radius: 5px;
      transition: background-color 0.3s ease, color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }

    .nav-link:hover {
      background-color: #2d3748;
      color: #fff;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 16px;
      color: #cbd5e0;
    }

    .logout-btn,
    .login-btn {
      background: #e53e3e;
      /* Red for logout */
      color: #fff;
      border: none;
      padding: 8px 12px; /* Reduzido de 10px 15px para 8px 12px */
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px; /* Reduzido de 15px para 14px */
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: flex;
      align-items: center;
      gap: 6px; /* Reduzido de 8px para 6px */
    }

    .login-btn {
      background: #3182ce;
      /* Blue for login */
    }


    .logout-btn:hover,
    .login-btn:hover {
      background-color: #c53030;
      transform: translateY(-1px);
    }

    /* Dropdown Styles */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #2d3748;
      /* Darker dropdown background */
      border-radius: 5px;
      padding: 5px 0;
      z-index: 100;
      min-width: 150px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.3s ease, transform 0.3s ease;
      flex-direction: column; /* Para os itens ficarem um abaixo do outro */
    }

    .dropdown:hover .dropdown-menu {
      display: flex;
      opacity: 1;
      transform: translateY(0);
    }

    .dropdown-item {
      color: #e2e8f0;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
      transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dropdown-item:hover {
      background-color: #4a5568;
      /* Lighter hover for dropdown items */
      color: #fff;
    }


    /* Icon styles */
    .fas {
      margin-right: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        padding: 15px;
        gap: 15px;
      }

      .header-center .nav-links {
        flex-direction: column;
        gap: 10px;
      }

      .header-right {
        flex-direction: column;
        gap: 10px;
      }

      .nav-link,
      .dropdown-item {
        width: 100%;
        text-align: center;
        padding: 10px;
      }

      .dropdown-menu {
        position: static; /* Remove absolute positioning on mobile */
        box-shadow: none;
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</header>

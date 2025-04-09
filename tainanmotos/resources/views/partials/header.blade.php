<header class="header">
    <div class="header-left">
     <h1><a href="{{ route('dashboard') }}" class="logo-link">Tainan Motos</a></h1>
    </div>

    <div class="header-center">
        <nav class="nav-links">
            <a href="/solicitar-manutencao" class="nav-link">
                <i class="fas fa-tools"></i> Solicitar
            </a>
            <a href="/visualizar-manutencao" class="nav-link">
                <i class="fas fa-eye"></i> Visualizar
            </a>
            <a href="/gerenciar-manutencao" class="nav-link">
                <i class="fas fa-wrench"></i> Gerenciar
            </a>

            <!-- Dropdown agrupado inteiro para evitar sumir -->
            <div class="dropdown">
                <div class="nav-link dropdown-toggle">
                    <i class="fas fa-plus"></i> Cadastrar
                </div>
                <div class="dropdown-menu">
                    <a href="/cadastrar-pecas" class="dropdown-item">Peças</a>
                </div>
            </div>
        </nav>
    </div>

    <div class="header-right">
        <span class="user-name">Usuário</span>
        <a href="#" class="settings-icon"><i class="fas fa-cog"></i></a>
        <button class="logout-btn">Sair</button>
    </div>
</header>

<style>
/* Header principal */
.header {
    background-color: rgb(17, 19, 20);
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap;
}

.header-left h1 {
    margin: 0;
    font-size: 22px;
}

.header-center {
    flex-grow: 1;
    text-align: center;
}

.nav-links {
    display: inline-flex;
    gap: 30px;
    align-items: center;
    position: relative;
}

/* Links do menu */
.nav-link {
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-size: 15px;
    transition: color 0.3s;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

.nav-link:hover {
    color: #007bff;
}

/* Área à direita */
.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-name {
    font-size: 16px;
    font-weight: bold;
}

.settings-icon i {
    font-size: 20px;
    color: white;
}

.logout-btn {
    background-color: #dc3545;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease-in-out;
}

.logout-btn:hover {
    background-color: #c82333;
}

/* Dropdown menu */
.dropdown {
    position: relative;
}

.dropdown:hover .dropdown-menu {
    display: flex;
    flex-direction: column;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgb(17, 19, 20);
    border-radius: 5px;
    padding: 5px 0;
    z-index: 100;
    min-width: 130px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
}

.dropdown-item {
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s;
    white-space: nowrap;
}

.dropdown-item:hover {
    background-color: #007bff;
}

.logo-link {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
}

.logo-link:hover {
    color: #007bff;
}

</style>

<!-- Font Awesome (obrigatório no <head>) -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->

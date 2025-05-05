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

            
            <div class="dropdown">
                <div class="nav-link dropdown-toggle">
                    <i class="fas fa-plus"></i> Cadastros
                </div>
                <div class="dropdown-menu">
                <a href="/cadastrar-peca" class="dropdown-item">Peça</a>
                <a href="/cadastrar-modelo" class="dropdown-item">Modelo</a>
                <a href="/cadastrar-fabricante" class="dropdown-item">Fabricante</a>
                <a href="/cadastrar-mao-de-obra" class="dropdown-item">Mão de Obra</a>

                </div>
            </div>
        </nav>
    </div>

    <div class="header-right">
        <span class="user-name">Usuário</span>
            <a href="#" class="settings-icon" onclick="abrirModalConfiguracoes()">
                <i class="fas fa-cog"></i>
        </a>
        <button class="logout-btn">Sair</button>
    </div>
</header>

<div id="modal-config" class="modal-config">
    <div class="modal-content">
        <span class="close-btn" onclick="fecharModalConfiguracoes()">&times;</span>
        <h2>Configurações</h2>
        <p>Aqui você pode personalizar suas preferências, alterar senha, etc.</p>
        
    </div>
</div>

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

.modal-config {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 30px;
    border-radius: 10px;
    width: 500px;
    position: relative;
    animation: fadeIn 0.3s ease;
}

.modal-content h2 {
    margin-top: 0;
}

.close-btn {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 24px;
    color: #aaa;
    cursor: pointer;
}

.close-btn:hover {
    color: #000;
}

</style>

<script>
function abrirModalConfiguracoes() {
    document.getElementById("modal-config").style.display = "block";
}

function fecharModalConfiguracoes() {
    document.getElementById("modal-config").style.display = "none";
}
</script>

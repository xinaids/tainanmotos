<header class="header">
    <div class="header-left">
        <h1>Tainan Motos</h1>
    </div>
    <div class="header-right">
        <span class="user-name">Usuário</span>
        <a href="#" class="settings-icon"><i class="fas fa-cog"></i></a>
        <button class="logout-btn">Sair</button>
    </div>
</header>

<style>
.header {
    background-color: #007bff;
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header-left h1 {
    margin: 0;
    font-size: 22px;
}

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
</style>

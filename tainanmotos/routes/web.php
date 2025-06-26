<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\FabricanteController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\MaoObraController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\EstatisticaController;
use App\Models\Modelo;
use App\Models\Fabricante;
use App\Models\Moto; // Importado para a rota da placa


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redireciona a rota raiz ('/') para a página de login
Route::get('/', fn() => redirect('/auth/login'));

// ==================== Autenticação ====================
Route::prefix('auth')->group(function () {
    // Exibe o formulário de login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Processa o login do usuário
    Route::post('/login', [LoginController::class, 'login']);
    // Realiza o logout do usuário
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Exibe o formulário de registro
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Processa o registro de um novo usuário
    Route::post('/register', [RegisterController::class, 'register']);

    // Exibe o formulário de recuperação de senha (ainda sem implementação completa)
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
});

// ==================== Dashboard ====================
// Exibe a página principal do dashboard
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

// ==================== Manutenções ====================
// Exibe o formulário para solicitar uma nova manutenção
Route::get('/solicitar-manutencao', function () {
    $modelos = Modelo::with('fabricante')->get();
    $marcas = Fabricante::orderBy('nome')->get(); // Ordenado alfabeticamente
    return view('solicitar_manutencao', compact('modelos', 'marcas'));
})->name('solicitar.manutencao');

// Processa a solicitação de uma nova manutenção
Route::post('/solicitar-manutencao', [ManutencaoController::class, 'store'])->name('manutencao.store');

// Exibe a lista de manutenções para o usuário logado
Route::get('/visualizar-manutencao', [ManutencaoController::class, 'visualizar'])->name('visualizar.manutencao');

// Exibe a página de gerenciamento de manutenções (para administradores/mecânicos)
Route::get('/gerenciar-manutencao', [ManutencaoController::class, 'gerenciar'])->name('gerenciar.manutencao');
// Rota alternativa, mantida por compatibilidade se usada em algum lugar
Route::get('/gerenciar_manutencao', [ManutencaoController::class, 'gerenciar'])->name('manutencao.gerenciar');

// Obtém os detalhes de um serviço específico (usado para popular o modal)
Route::get('/servico/{id}', [ServicoController::class, 'show']);

// Atualiza a descrição, situação, peças e mão de obra de uma manutenção
Route::post('/manutencao/{id}/descricao', [ManutencaoController::class, 'atualizarDescricao'])->name('manutencao.atualizarDescricao');

// Rota para atualização de serviço, mantida se ServicoController tiver lógica específica
Route::post('/servico/{id}/atualizar', [ServicoController::class, 'atualizar'])->name('servico.atualizar');

// ==================== Cadastro e Gerenciamento (CRUD) ====================

// --- Fabricante ---
// Exibe o formulário para cadastrar um novo fabricante
Route::get('/cadastrar-fabricante', [FabricanteController::class, 'create'])->name('cadastrarfabricante');
// Processa o cadastro de um novo fabricante
Route::post('/cadastrar-fabricante', [FabricanteController::class, 'store'])->name('fabricante.store');
// Exibe a lista de fabricantes
Route::get('/fabricantes', [FabricanteController::class, 'index'])->name('fabricante.index');
// Exibe o formulário para editar um fabricante existente
Route::get('/fabricante/{id}/edit', [FabricanteController::class, 'edit'])->name('fabricante.edit');
// Processa a atualização de um fabricante
Route::put('/fabricante/{id}', [FabricanteController::class, 'update'])->name('fabricante.update');
// Deleta um fabricante
Route::delete('/fabricante/{id}', [FabricanteController::class, 'destroy'])->name('fabricante.destroy');
// Nota: 'Route::resource('fabricante', FabricanteController::class)->only([]);' é redundante se você definir rotas manualmente.

// --- Modelo ---
// Exibe a lista de modelos
Route::get('/modelos', [ModeloController::class, 'index'])->name('modelo.index');
// Exibe o formulário para cadastrar um novo modelo
Route::get('/cadastrar-modelo', [ModeloController::class, 'create'])->name('modelo.create');
// Processa o cadastro de um novo modelo
Route::post('/modelos', [ModeloController::class, 'store'])->name('modelo.store');
// Exibe o formulário para editar um modelo existente
Route::get('/modelos/{id}/edit', [ModeloController::class, 'edit'])->name('modelo.edit');
// Processa a atualização de um modelo
Route::put('/modelos/{id}', [ModeloController::class, 'update'])->name('modelo.update');
// Deleta um modelo
Route::delete('/modelos/{id}', [ModeloController::class, 'destroy'])->name('modelo.destroy');

// --- Peça ---
// Exibe a lista de peças
Route::get('/pecas', [PecaController::class, 'index'])->name('pecas.index');
// Exibe o formulário para cadastrar uma nova peça
Route::get('/cadastrar-peca', [PecaController::class, 'create'])->name('pecas.create');
// Processa o cadastro de uma nova peça
Route::post('/pecas', [PecaController::class, 'store'])->name('pecas.store');
// Exibe o formulário para editar uma peça existente
Route::get('/pecas/{codigo}/edit', [PecaController::class, 'edit'])->name('pecas.edit');
// Processa a atualização de uma peça
Route::put('/pecas/{codigo}', [PecaController::class, 'update'])->name('pecas.update');
// Deleta uma peça
Route::delete('/pecas/{codigo}', [PecaController::class, 'destroy'])->name('pecas.destroy');

// --- Mão de Obra ---
// Exibe a lista de mão de obra
Route::get('/maodeobra', [MaoObraController::class, 'index'])->name('maoobra.index');
// Exibe o formulário para cadastrar um novo item de mão de obra
Route::get('/cadastrar-mao-de-obra', [MaoObraController::class, 'create'])->name('maoobra.create');
// Processa o cadastro de um novo item de mão de obra
Route::post('/maodeobra', [MaoObraController::class, 'store'])->name('maoobra.store');
// Exibe o formulário para editar um item de mão de obra existente
Route::get('/maodeobra/{id}/edit', [MaoObraController::class, 'edit'])->name('maoobra.edit');
// Processa a atualização de um item de mão de obra
Route::put('/maodeobra/{id}', [MaoObraController::class, 'update'])->name('maoobra.update');
// Deleta um item de mão de obra
Route::delete('/maodeobra/{id}', [MaoObraController::class, 'destroy'])->name('maoobra.destroy');
// Rota API para listar itens de mão de obra (usado em AJAX)
Route::get('/api/mao-de-obra', [MaoObraController::class, 'listar'])->name('maoobra.listar');


// --- Motos ---
// Exibe a lista de motos
Route::get('/motos', [MotoController::class, 'index'])->name('motos.index');
// Rota alternativa, mantida por compatibilidade
Route::get('/motos', [MotoController::class, 'index'])->name('moto.index');


// ==================== Estatísticas ====================
// Exibe a página de estatísticas
Route::get('/estatisticas', [EstatisticaController::class, 'index'])->name('estatisticas');

// ==================== Rotas AJAX/API Específicas ====================
// Obtém modelos de motos por fabricante (usado em AJAX)
Route::get('/modelos-por-fabricante/{fabricante_id}', function ($fabricante_id) {
    return response()->json(
        Modelo::where('cod_fabricante', $fabricante_id)
            ->orderBy('nome')
            ->get(['codigo', 'nome'])
    );
})->name('modelos.por.fabricante');

// Obtém peças por modelo (usado em AJAX)
Route::get('/api/pecas/{codModelo}', [PecaController::class, 'pecasPorModelo']);

// Obtém dados da moto por placa (usado em AJAX)
Route::get('/moto/por-placa/{placa}', function ($placa) {
    $moto = Moto::with('modelo.fabricante')->where('placa', $placa)->first();

    if ($moto) {
        return response()->json([
            'cor' => $moto->cor,
            'ano' => $moto->ano,
            'modelo' => $moto->modelo->codigo,
            'marca' => $moto->modelo->fabricante->codigo
        ]);
    } else {
        return response()->json(null, 404);
    }
});

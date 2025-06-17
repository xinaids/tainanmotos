<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\FabricanteController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\MaoObraController;
use App\Models\Modelo;
use App\Models\Fabricante;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\ServicoController;
use App\Models\Moto;






// Redirecionar root para login
Route::get('/', fn () => redirect('/login'));

// Autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Esqueci a senha
Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');

// Dashboard
Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

// Manutenções
Route::get('/solicitar-manutencao', function () {
    $modelos = Modelo::with('fabricante')->get();
    $marcas = Fabricante::orderBy('nome')->get(); // ordenado alfabeticamente
    return view('solicitar_manutencao', compact('modelos', 'marcas'));
})->name('solicitar.manutencao');

Route::get('/visualizar-manutencao', [ManutencaoController::class, 'visualizar'])
    ->name('visualizar.manutencao');

Route::get('/gerenciar-manutencao', fn () => view('gerenciar_manutencao'))->name('gerenciar.manutencao');

// AJAX para obter modelos por fabricante
Route::get('/modelos-por-fabricante/{fabricante_id}', function ($fabricante_id) {
    return response()->json(
        Modelo::where('cod_fabricante', $fabricante_id)
            ->orderBy('nome')
            ->get(['codigo', 'nome'])
    );
})->name('modelos.por.fabricante');

// Cadastro direto via view
Route::get('/motos', fn () => view('motos'))->name('motos');

// Fabricante
Route::get('/cadastrar-fabricante', [FabricanteController::class, 'create'])->name('cadastrarfabricante');
Route::post('/cadastrar-fabricante', [FabricanteController::class, 'store'])->name('fabricante.store');
Route::get('/fabricantes', [FabricanteController::class, 'index'])->name('fabricante.index');
Route::get('/fabricante/{id}/edit', [FabricanteController::class, 'edit'])->name('fabricante.edit');
Route::put('/fabricante/{id}', [FabricanteController::class, 'update'])->name('fabricante.update');
Route::delete('/fabricante/{id}', [FabricanteController::class, 'destroy'])->name('fabricante.destroy');
Route::resource('fabricante', FabricanteController::class)->only([]);

// Modelo
Route::get('/modelos', [ModeloController::class, 'index'])->name('modelo.index');
Route::get('/cadastrar-modelo', [ModeloController::class, 'create'])->name('modelo.create');
Route::post('/modelos', [ModeloController::class, 'store'])->name('modelo.store');
Route::get('/modelos/{id}/edit', [ModeloController::class, 'edit'])->name('modelo.edit');
Route::put('/modelos/{id}', [ModeloController::class, 'update'])->name('modelo.update');
Route::delete('/modelos/{id}', [ModeloController::class, 'destroy'])->name('modelo.destroy');

// Peça
Route::get('/pecas', [PecaController::class, 'index'])->name('pecas.index');
Route::get('/cadastrar-peca', [PecaController::class, 'create'])->name('pecas.create');
Route::post('/pecas', [PecaController::class, 'store'])->name('pecas.store');
Route::get('/pecas/{codigo}/edit', [PecaController::class, 'edit'])->name('pecas.edit');
Route::put('/pecas/{codigo}', [PecaController::class, 'update'])->name('pecas.update');
Route::delete('/pecas/{codigo}', [PecaController::class, 'destroy'])->name('pecas.destroy');

// Mão de Obra
Route::get('/maodeobra', [MaoObraController::class, 'index'])->name('maoobra.index');
Route::get('/cadastrar-mao-de-obra', [MaoObraController::class, 'create'])->name('maoobra.create');
Route::post('/maodeobra', [MaoObraController::class, 'store'])->name('maoobra.store');
Route::get('/maodeobra/{id}/edit', [MaoObraController::class, 'edit'])->name('maoobra.edit');
Route::put('/maodeobra/{id}', [MaoObraController::class, 'update'])->name('maoobra.update');
Route::delete('/maodeobra/{id}', [MaoObraController::class, 'destroy'])->name('maoobra.destroy');
Route::get('/mao-obra/listar', [MaoObraController::class, 'listar'])->name('maoobra.listar');



//manutencao

Route::post('/solicitar-manutencao', [ManutencaoController::class, 'store'])->name('manutencao.store');
Route::post('/manutencao/atualizar', [ManutencaoController::class, 'atualizar'])->name('manutencao.atualizar');
Route::post('/manutencao/{id}/descricao', [ManutencaoController::class, 'atualizarDescricao'])->name('manutencao.atualizarDescricao');
Route::get('/servico/{id}', [\App\Http\Controllers\ServicoController::class, 'show']);
Route::post('/manutencao/{id}/descricao', [ManutencaoController::class, 'atualizarDescricao'])->name('manutencao.atualizarDescricao');


//motos
Route::get('/motos', [MotoController::class, 'index'])->name('motos');
Route::get('/gerenciar_manutencao', [ManutencaoController::class, 'gerenciar'])->name('manutencao.gerenciar');
Route::get('/gerenciar-manutencao', [ManutencaoController::class, 'gerenciar'])->name('gerenciar.manutencao');

Route::get('/servico/{id}', [ServicoController::class, 'show']);
Route::post('/manutencao/{id}/descricao', [ServicoController::class, 'atualizarDescricao'])->name('manutencao.descricao');
Route::post('/servico/{id}/atualizar', [ServicoController::class, 'atualizar'])->name('servico.atualizar');


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
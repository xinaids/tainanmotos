<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FabricanteController;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/solicitar-manutencao', function () {
    return view('solicitar_manutencao');
})->name('solicitar.manutencao');

Route::get('/visualizar-manutencao', function () {
    return view('visualizar_manutencao');
})->name('visualizar.manutencao');

Route::get('/gerenciar-manutencao', function () {
    return view('gerenciar_manutencao');
})->name('gerenciar.manutencao');


Route::get('/cadastrar-peca', function () {
    return view('cadastrar-peca'); 
})->name('cadastrar-peca');

Route::get('/cadastrar-modelo', function () {
    return view('cadastrar-modelo'); 
})->name('cadastrar-modelo');

Route::get('/cadastrar-fabricante', function () {
    return view('cadastrar-fabricante'); 
})->name('cadastrar-fabricante');

Route::get('/cadastrar-mao-de-obra', function () {
    return view('cadastrar-mao-de-obra'); 
})->name('cadastrar-mao-de-obra');

Route::get('/motos', function () {
    return view('motos'); 
})->name('motos');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/cadastrar-fabricante', function () {
    return view('cadastrar-fabricante');
})->name('cadastrar-fabricante');

Route::post('/cadastrar-fabricante', [FabricanteController::class, 'store'])->name('fabricante.store');
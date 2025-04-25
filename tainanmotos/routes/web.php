<?php

use Illuminate\Support\Facades\Route;

// Rota para o login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Rota para o cadastro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rota para a tela "Esqueci minha senha"
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Rota para o Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rota para Solicitar Manutenção
Route::get('/solicitar-manutencao', function () {
    return view('solicitar_manutencao');
})->name('solicitar.manutencao');

// Rota para Visualizar Manutenção
Route::get('/visualizar-manutencao', function () {
    return view('visualizar_manutencao');
})->name('visualizar.manutencao');

// Rota para Gerenciar Manutenção
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
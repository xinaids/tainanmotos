<?php



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


Route::get('/dashboard', function () {
    return view('dashboard');  // Chama a view dashboard.blade.php
});

Route::get('/solicitar-manutencao', function () {
    return view('solicitar_manutencao');
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // ou 'login' se seu arquivo for 'resources/views/login.blade.php'
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticado com sucesso
            return redirect()->intended('dashboard'); // ou a página que quiser depois do login
        }

        // Falha no login
        return back()->withErrors([
            'email' => 'As credenciais informadas não foram encontradas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

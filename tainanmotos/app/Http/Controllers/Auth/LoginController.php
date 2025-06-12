<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->senha)) {
            // Autenticar manualmente
            session(['usuario' => $usuario]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email ou senha inválidos.'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('usuario');
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // app/Http/Controllers/Auth/RegisterController.php
    protected function registered(Request $request, $user)
    {
        // qualquer lógica extra …

        return redirect()
            ->route('login')
            ->with('register_success', true);
    }


    public function register(Request $request)
    {
        $cpf = preg_replace('/\D/', '', $request->cpf); // remove pontuação
        $phone = preg_replace('/\D/', '', $request->phone); // idem

        $data = $request->all();
        $data['cpf'] = $cpf;
        $data['phone'] = $phone;

        $this->validator($data)->validate();

        $this->create($data);

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Faça login.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:70'],
            'email' => ['required', 'string', 'email', 'max:60', 'unique:usuario,email'],
            'phone' => ['required', 'digits_between:10,11'],
            'cpf' => ['required', 'digits:11', 'unique:usuario,cpf'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Usuario::create([
            'cpf' => $data['cpf'],
            'nome' => $data['name'],
            'email' => $data['email'],
            'telefone' => $data['phone'],
            'senha' => Hash::make($data['password']),
            'tipo' => 1,
        ]);
    }
}

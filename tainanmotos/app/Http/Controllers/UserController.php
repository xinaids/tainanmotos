<?php

namespace App\Http\Controllers;

use App\Models\User; // Importe o modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Para hashing de senha, se necessário
use Illuminate\Validation\Rule; // Para validação de unicidade na atualização

class UserController extends Controller
{
    /**
     * Exibe uma lista paginada de usuários.
     * Permite ordenação e pesquisa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtém parâmetros de ordenação e pesquisa da requisição
        $ordenarPor = $request->input('ordenar_por', 'nome'); // Padrão: nome
        $ordem = $request->input('ordem', 'asc'); // Padrão: ascendente
        $pesquisa = $request->input('pesquisa');

        // Valida os campos de ordenação permitidos
        $colunasPermitidas = ['nome', 'email', 'cpf', 'telefone']; // Adicionado 'telefone'
        if (!in_array($ordenarPor, $colunasPermitidas)) {
            $ordenarPor = 'nome';
        }

        // Inicia a query do modelo User
        $query = User::query();

        // Aplica filtro de pesquisa se houver
        if ($pesquisa) {
            $query->where(function ($q) use ($pesquisa) {
                $q->where('nome', 'like', '%' . $pesquisa . '%')
                  ->orWhere('email', 'like', '%' . $pesquisa . '%')
                  ->orWhere('cpf', 'like', '%' . $pesquisa . '%')
                  ->orWhere('telefone', 'like', '%' . $pesquisa . '%');
            });
        }

        // Aplica a ordenação
        $query->orderBy($ordenarPor, $ordem);

        // Pagina os resultados
        $usuarios = $query->paginate(10); // 10 usuários por página

        return view('usuario.index', compact('usuarios'));
    }

    /**
     * Mostra o formulário para editar um usuário específico.
     * O ID passado aqui é o CPF, pois é a chave primária.
     *
     * @param  string  $cpf O CPF (chave primária) do usuário a ser editado.
     * @return \Illuminate\View\View
     */
    public function edit($cpf)
    {
        // Encontra o usuário pelo CPF ou falha
        $usuario = User::where('cpf', $cpf)->firstOrFail();
        return view('usuario.edit', compact('usuario'));
    }

    /**
     * Atualiza os dados de um usuário no banco de dados.
     * O ID passado aqui é o CPF, pois é a chave primária.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cpf O CPF (chave primária) do usuário a ser atualizado.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cpf)
    {
        // Encontra o usuário pelo CPF
        $usuario = User::where('cpf', $cpf)->firstOrFail();

        // Regras de validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:60', // Conforme o VARCHAR(60) do seu SQL
                Rule::unique('users', 'email')->ignore($usuario->cpf, 'cpf'), // Garante que o email é único, exceto para o próprio usuário, usando 'cpf' como coluna da PK
            ],
            'telefone' => 'required|string|max:11', // NUMERIC(11,0) no SQL, então 11 dígitos
            'cpf' => [
                'required',
                'string',
                'max:11', // NUMERIC(11,0) no SQL, então 11 dígitos
                Rule::unique('users', 'cpf')->ignore($usuario->cpf, 'cpf'), // Garante que o CPF é único, exceto para o próprio usuário, usando 'cpf' como coluna da PK
            ],
            'tipo' => 'required|integer|in:1,2', // 1 para Cliente, 2 para Administrador
            'password' => 'nullable|string|min:8|confirmed', // Senha opcional, mas se preenchida, deve ter min 8 e ser confirmada
        ]);

        // Atualiza os campos do usuário
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->telefone = $request->telefone; // Nome da coluna 'telefone'
        $usuario->cpf = $request->cpf;
        $usuario->tipo = $request->tipo;

        // Se uma nova senha for fornecida, faça o hash e atualize
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save(); // Salva as alterações no banco de dados

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário do banco de dados.
     * O ID passado aqui é o CPF, pois é a chave primária.
     *
     * @param  string  $cpf O CPF (chave primária) do usuário a ser excluído.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cpf)
    {
        // Encontra o usuário pelo CPF ou falha
        $usuario = User::where('cpf', $cpf)->firstOrFail();
        $usuario->delete(); // Deleta o usuário

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}

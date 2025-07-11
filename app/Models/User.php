<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * O nome da tabela associada ao modelo.
     * Por padrão, o Eloquent usa o nome da classe em minúsculas e plural (users).
     * Como sua tabela é 'usuario', precisamos especificar.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * A chave primária da tabela.
     * Por padrão, o Eloquent assume 'id'.
     * Como sua PK é 'cpf', precisamos especificar.
     *
     * @var string
     */
    protected $primaryKey = 'cpf';

    /**
     * Indica se a chave primária é auto-incrementável.
     * Como 'cpf' não é auto-incrementável, definimos como false.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * O tipo de dado da chave primária.
     * Como 'cpf' é NUMERIC (e será tratado como string no PHP para evitar problemas de precisão com números grandes),
     * definimos como 'string'.
     *
     * @var string
     */
    protected $keyType = 'string';


    /**
     * Os atributos que são atribuíveis em massa.
     * Ajustados para corresponder aos nomes das colunas em sua tabela 'usuario'.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cpf',
        'nome',
        'senha', // Corrigido de 'password' para 'senha'
        'email',
        'telefone', // Corrigido de 'phone' para 'telefone'
        'tipo', // Adicionado 'tipo' para atribuição em massa
    ];

    /**
     * Os atributos que devem ser ocultados para serialização.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha', // Corrigido de 'password' para 'senha'
        'remember_token',
    ];

    /**
     * Obtém os atributos que devem ser convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha' => 'hashed', // Corrigido de 'password' para 'senha'
            'cpf' => 'string', // Garante que o CPF seja tratado como string
            'telefone' => 'string', // Garante que o telefone seja tratado como string
            'tipo' => 'integer', // Garante que o tipo seja tratado como inteiro
        ];
    }
}

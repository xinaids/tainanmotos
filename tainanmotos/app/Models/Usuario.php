<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario'; // Nome da tabela
    protected $primaryKey = 'cpf'; // PK é CPF

    public $incrementing = false; // CPF não é autoincremento
    protected $keyType = 'string'; // CPF é string

    protected $fillable = [
        'cpf', 'nome', 'email', 'telefone', 'senha', 'tipo',
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->senha; // Laravel busca senha aqui
    }
}

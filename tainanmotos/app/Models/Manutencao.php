<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model
{
    protected $table = 'manutencaos'; // nome da tabela no banco

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'cor',
        'quilometragem',
        'ano',
        'descricao',
        'usuario_cpf',
        'data_abertura'
    ];

    public $timestamps = true;
}

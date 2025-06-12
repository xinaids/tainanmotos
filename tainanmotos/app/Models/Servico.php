<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servico';

    protected $fillable = [
        'data_abertura',
        'data_fechamento',
        'descricao',
        'valor',
        'quilometragem',
        'situacao',
        'descricao_manutencao',
        'cod_moto'
    ];

    public $timestamps = false;

    public function moto()
    {
        return $this->belongsTo(Moto::class, 'cod_moto');
    }
}

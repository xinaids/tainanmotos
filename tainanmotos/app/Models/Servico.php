<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servico';
    protected $primaryKey = 'codigo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'data_abertura',
        'descricao',
        'valor',
        'quilometragem',
        'situacao',
        'cod_moto'
    ];

    public function moto()
    {
        return $this->belongsTo(\App\Models\Moto::class, 'cod_moto');
    }



    public function maosObra()
    {
        return $this->belongsToMany(MaoObra::class, 'servico_maodeobra', 'cod_servico', 'cod_maodeobra')
            ->withPivot('quantidade');
    }
}

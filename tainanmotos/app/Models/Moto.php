<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    protected $table = 'moto';
    protected $primaryKey = 'codigo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['placa', 'cor', 'ano', 'cod_modelo', 'cpf_usuario'];

    public function modelo()
    {
        return $this->belongsTo(\App\Models\Modelo::class, 'cod_modelo', 'codigo');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'cpf_usuario', 'cpf');
    }
}

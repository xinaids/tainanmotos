<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelo'; // nome exato da tabela no banco
    protected $primaryKey = 'codigo'; // <- ISSO é essencial
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nome', 'cod_fabricante'];

    public function pecas()
    {
        return $this->hasMany(Peca::class, 'cod_modelo');
    }

    public function fabricante()
{
    return $this->belongsTo(Fabricante::class, 'cod_fabricante');
}

public function servicos()
{
    return $this->hasManyThrough(
        \App\Models\Servico::class,
        \App\Models\Moto::class,
        'cod_modelo', // foreign key de Moto que aponta para Modelo
        'cod_moto',   // foreign key de Servico que aponta para Moto
        'codigo',     // chave local do Modelo
        'codigo'      // chave local do Moto
    );
}


}

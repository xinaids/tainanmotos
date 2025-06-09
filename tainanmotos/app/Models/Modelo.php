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
}

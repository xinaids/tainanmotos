<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    protected $table = 'moto'; // nome da tabela

    protected $fillable = [
        'placa',
        'cor',
        'ano',
        'cod_modelo',
    ];

    public $timestamps = false;

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'cod_modelo');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoPeca extends Model
{
    protected $table = 'servico_peca';
    public $timestamps = false;

    protected $fillable = [
        'cod_servico',
        'cod_peca',
        'quantidade'
    ];
}

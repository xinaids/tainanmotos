<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
    protected $table = 'peca';
    protected $primaryKey = 'codigo'; // <- isso corrige o erro!
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nome', 'preco', 'cod_modelo'];

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'cod_modelo');
    }
}

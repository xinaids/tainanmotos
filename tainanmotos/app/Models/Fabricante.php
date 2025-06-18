<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    protected $table = 'fabricante';
    protected $primaryKey = 'codigo';
    public $timestamps = false;

    protected $fillable = ['nome'];

    public function modelos()
{
    return $this->hasMany(\App\Models\Modelo::class, 'cod_fabricante', 'codigo');
}


}

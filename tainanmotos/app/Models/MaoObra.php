<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaoObra extends Model
{
    protected $table = 'maodeobra';

    protected $primaryKey = 'codigo';
    public $timestamps = false;

    protected $fillable = ['nome', 'valor'];
}

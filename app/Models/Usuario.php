<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'cpf', 'nome', 'email', 'telefone', 'senha', 'tipo',
    ];

    protected $hidden = [
        'senha',
    ];
}

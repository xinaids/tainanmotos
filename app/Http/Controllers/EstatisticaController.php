<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fabricante;

class EstatisticaController extends Controller
{
public function index()
{
    $fabricantes = Fabricante::with(['modelos' => function ($query) {
        $query->withCount('servicos');
    }])->get();

    $dados = $fabricantes->map(function ($fabricante) {
        return [
            'fabricante' => $fabricante->nome,
            'modelos' => $fabricante->modelos->map(function ($modelo) {
                return [
                    'nome' => $modelo->nome,
                    'qtd_chamados' => $modelo->servicos_count,
                ];
            }),
        ];
    });

    return view('estatisticas.index', ['dados' => $dados]);
}

}

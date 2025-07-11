<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use Illuminate\Support\Facades\DB;

class MotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Moto::with(['modelo.fabricante', 'usuario']);

        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $query->whereRaw('LOWER(placa) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(cor) LIKE ?', ["%{$search}%"])
                ->orWhereHas('modelo', function ($q) use ($search) {
                    $q->whereRaw('LOWER(nome) LIKE ?', ["%{$search}%"]);
                })
                ->orWhereHas('modelo.fabricante', function ($q) use ($search) {
                    $q->whereRaw('LOWER(nome) LIKE ?', ["%{$search}%"]);
                })
                ->orWhereHas('usuario', function ($q) use ($search) {
                    $q->whereRaw('LOWER(nome) LIKE ?', ["%{$search}%"]);
                });
        }

        $motos = $query->paginate(10);

        return view('motos', compact('motos'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;

class MotoController extends Controller
{
    public function index()
    {
        // Carrega as relações com modelo, fabricante e usuário
        $motos = Moto::with(['modelo.fabricante', 'usuario'])->get();
        
        return view('motos', compact('motos'));
    }
}

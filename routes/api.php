<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaoObraController;

Route::get('/mao-de-obra', [MaoObraController::class, 'listar']);

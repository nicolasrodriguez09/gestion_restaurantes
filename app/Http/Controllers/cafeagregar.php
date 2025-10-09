<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cafeagregar extends Controller
{
    // Método que redirige a la vista 'cafecomprar'
    public function comprar()
    {
        return view('cafecomprar');
    }
}

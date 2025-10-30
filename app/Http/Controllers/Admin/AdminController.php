<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // Por ahora reutilizamos la vista dashboard existente.
        return view('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('autopartes.index');
    }

    public function empleado()
    {
        return view('empleado.dashboard'); // Crear una vista para el dashboard del empleado
    }

    public function cliente()
    {
        return view('cliente.dashboard'); // Crear una vista para el dashboard del cliente
    }
}
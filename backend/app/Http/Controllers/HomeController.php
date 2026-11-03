<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function empleado()
    {
        return redirect()->route('autopartes.index'); // Redirige al listado de autopartes después de iniciar sesión como empleado
    }
}
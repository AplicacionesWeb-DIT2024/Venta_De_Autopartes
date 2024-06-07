<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autopart;
use App\Models\Carrito;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

class AutopartController extends Controller
{
    public function create()
    {
        return view('autopartes.crear');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autopart;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException; // Importa QueryException

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
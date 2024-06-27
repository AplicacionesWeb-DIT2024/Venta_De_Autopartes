<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Autopart;
use Auth;



class CarritoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Cliente')->except('index', 'show');
    }
    public function index()
    {
        $carrito = Auth::user()->carrito;
        return view('carrito.carrito', compact('carrito'));
    }

    public function store(Request $request)
    {
        $carrito = Auth::user()->carrito()->firstOrCreate([]);
        $carrito->autopartes()->attach($request->autopart_id);
        return redirect()->route('carrito.carrito');
    }

    public function destroy($id)
    {
        $carrito = Auth::user()->carrito;
        $carrito->autopartes()->detach($id);
        return redirect()->route('carrito.carrito');
    }

    public function show($id)
    {
        $autopart = Autopart::findOrFail($id);
        return view('autopartes.producto', compact('autopart'));
    }
}
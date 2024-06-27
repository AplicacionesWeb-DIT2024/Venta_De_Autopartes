<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use Auth;

class PedidoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Cliente')->except('index', 'show');
    }
    public function index()
    {
        $pedidos = Auth::user()->pedidos;
        return view('pedidos.pedidos', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Auth::user()->pedidos()->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }

    public function store(Request $request)
    {
        $pedido = Auth::user()->pedidos()->create([]);
        // Agregar lógica para asociar autopartes al pedido
        return redirect()->route('pedidos.pedidos');
    }

}
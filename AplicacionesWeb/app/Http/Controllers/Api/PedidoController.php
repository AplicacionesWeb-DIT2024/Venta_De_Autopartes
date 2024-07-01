<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Pedido;
use App\Models\DetallePedido;

class PedidoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Cliente')->except('index', 'show');
    }

    public function index()
    {
        $pedidos = Pedido::orderByDesc('created_at')->get();

        return view('pedidos.pedidos', compact('pedidos'));
    }

    public function show($id)
    {
        // Utiliza findOrFail para obtener el pedido del usuario autenticado por su ID
        $pedido = Pedido::with('detalles')->findOrFail($id);
        return view('pedidos.detalle', compact('pedido'));
    }

    public function store(Request $request)
    {
        $pedido = Auth::user()->pedidos()->create([]);
        return redirect()->route('pedidos.pedidos');
    }

}
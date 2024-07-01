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
        // Filtra los pedidos por el usuario autenticado
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('created_at')->get();

        return view('pedidos.pedidos', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::where('user_id', Auth::id())->findOrFail($id);
        $detalles = DetallePedido::where('pedido_id', $pedido->id)->get();

        return view('pedidos.detalle', compact('pedido', 'detalles'));
    }

    public function store(Request $request)
    {
        // Contar los pedidos existentes del usuario actual
        $countPedidos = Pedido::where('user_id', Auth::id())->count();

        // Crear un nuevo pedido
        $pedido = new Pedido();
        $pedido->user_id = Auth::id();
        $pedido->fecha_cierre = now(); // Opcional: puedes definir la fecha de cierre aquí
        $pedido->costo_total = 0; // Inicializar costo total según tu lógica
        $pedido->tipo_pago = ''; // Inicializar tipo de pago según tu lógica
        $pedido->save();

        // Actualizar el ID del pedido con el contador + 1
        $pedido->id = $countPedidos + 1;
        $pedido->save();

        return redirect()->route('pedidos.pedidos');
    }
}
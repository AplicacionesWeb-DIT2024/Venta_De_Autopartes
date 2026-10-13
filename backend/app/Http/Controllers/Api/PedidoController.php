<?php

namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado


class PedidoController extends Controller
{
    // Lista de pedidos del usuario
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('fecha_cierre')->get();
        return view('pedidos.pedidos', compact('pedidos')); // Retorna la vista con los pedidos del usuario
    }

    // Detalle de un pedido
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('detalles')
            ->firstOrFail();

        return view('pedidos.detalle', compact('pedido')); // Retorna la vista con los detalles del pedido
    }
}

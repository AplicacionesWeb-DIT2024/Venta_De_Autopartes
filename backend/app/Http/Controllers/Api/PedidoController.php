<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado


class PedidoController extends Controller
{
    // Mostrar todos los pedidos del usuario autenticado
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('fecha_cierre')->get();
        return view('pedidos.pedidos', compact('pedidos'));
    }

    // Mostrar los detalles de un pedido específico del usuario autenticado
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('detalles')
            ->firstOrFail();

        return view('pedidos.detalle', compact('pedido'));
    }
}

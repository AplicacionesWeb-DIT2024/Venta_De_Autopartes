<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado


class PedidoController extends Controller
{
    // Lista de pedidos del usuario
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->orderByDesc('fecha_cierre')
            ->get();

        return response()->json($pedidos);
    }

    // Detalle de un pedido
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('detalles')
            ->firstOrFail();

        return response()->json($pedido);
    }

    // Eliminar un pedido
    public function destroy($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pedido->detalles()->delete(); // Eliminar los detalles del pedido antes de eliminar el pedido
        $pedido->delete(); // Eliminar el pedido

        return response()->json([
            'message' => 'Pedido eliminado'
        ]);
    }
}

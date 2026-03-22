<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Pedido;
use App\Models\DetallePedido;

class PedidoController extends Controller
{// Método para mostrar los pedidos del usuario autenticado
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->with('detalles')->get();
        return response()->json($pedidos);
    }

    // Método para mostrar los detalles de un pedido específico
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)->where('user_id', Auth::id())->with('detalles')->first();
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        return response()->json($pedido);
    }

    // Método para crear un nuevo pedido
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total' => 'required|numeric',
            'estado' => 'required|string',
        ]);

        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'total' => $validated['total'],
            'estado' => $validated['estado'],
        ]);

        return response()->json($pedido, 201);
    }
}
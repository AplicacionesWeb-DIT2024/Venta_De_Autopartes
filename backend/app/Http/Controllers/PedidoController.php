<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    // Método para mostrar la lista de pedidos del usuario autenticado
    public function index()
    {
        $pedidos =
            Pedido::where('user_id', Auth::id()) // Filtramos los pedidos por el ID del usuario autenticado
                ->orderBy('created_at', 'desc')->get();

        return view('pedidos.index', compact('pedidos'));
    }
    // Método para mostrar los detalles de un pedido específico
    public function show($id)
    {
        $pedido = Pedido::where('id', $id) // Filtramos el pedido por su ID
            ->where('user_id', Auth::id()) // Aseguramos que el pedido pertenece al usuario autenticado
            ->with('detalles') // Cargamos la relación 'detalles' del pedido
            ->firstOrFail(); // Obtenemos el pedido o lanzamos un error 404

        return view('pedidos.detalle', compact('pedido'));
    }
}
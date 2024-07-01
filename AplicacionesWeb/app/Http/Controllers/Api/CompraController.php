<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Cliente')->except('index', 'show');
    }

    public function pagar()
    {
        $carritoItems = Carrito::with('autoparte')->where('user_id', Auth::id())->get();
        return view('carrito.pagar', compact('carritoItems'));
    }

    public function comprar(Request $request)
    {
        $carritoItems = Carrito::with('autoparte')->where('user_id', Auth::id())->get();

        // Filtrar los items que tienen autoparte asociada
        $carritoItems = $carritoItems->filter(function ($item) {
            return $item->autopart !== null;
        });

        // Crear el pedido
        $pedido = Pedido::create([
            'user_id' => Auth::id(), // Asignar el user_id del usuario autenticado
            'fecha_cierre' => now(),
            'costo_total' => $carritoItems->sum(function ($item) {
                return $item->autopart->precio * $item->quantity;
            }),
            'tipo_pago' => $request->forma_pago,
        ]);

        // Crear los detalles del pedido
        foreach ($carritoItems as $item) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'autoparte' => $item->autopart->autoparte,
                'marca' => $item->autopart->marca,
                'modelo' => $item->autopart->modelo,
                'codigo' => $item->autopart->codigo,
                'precio' => $item->autopart->precio,
                'cantidad' => $item->quantity,
            ]);

            // Eliminar la autoparte del listado de autopartes
            $item->autopart->delete();

            // Eliminar el item del carrito
            $item->delete();
        }

        return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Compra realizada con éxito.');
    }
}
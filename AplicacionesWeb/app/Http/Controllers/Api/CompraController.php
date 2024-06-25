<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Autopart;
use App\Models\Pedido;
use App\Models\DetallePedido;


class CompraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:cliente');
    }
    public function pagar()
    {
        $carritoItems = Carrito::with('autopart')->get();
        return view('carrito.pagar', compact('carritoItems'));
    }

    public function comprar(Request $request)
    {
        $carritoItems = Carrito::with('autopart')->get();

        // Crear el pedido
        $pedido = Pedido::create([
            'fecha_cierre' => now(),
            'costo_total' => $carritoItems->sum('autopart.precio'),
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
            ]);

            // Eliminar la autoparte del listado de autopartes
            $item->autopart->delete();

            $item->delete();  // Eliminar el item del carrito
        }

        return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Compra realizada con éxito.');
    }
}
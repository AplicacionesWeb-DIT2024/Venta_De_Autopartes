<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Autopart;
use App\Models\Pedido;

class CompraController extends Controller
{
    public function pagar()
    {
        $carritoItems = Carrito::with('autopart')->get();
        return view('carrito.pagar', compact('carritoItems'));
    }

    public function comprar(Request $request)
    {
        // Validar la forma de pago
        $request->validate([
            'forma_pago' => 'required|string',
        ]);

        // Obtener el último número de pedido
        $lastOrder = Pedido::orderBy('id', 'desc')->first();
        $nextOrderNumber = $lastOrder ? $lastOrder->id + 1 : 1;

        // Obtener todos los productos en el carrito
        $carritoItems = Carrito::with('autopart')->get();

        foreach ($carritoItems as $item) {
            // Crear un nuevo registro en la tabla pedidos
            Pedido::create([
                'numero_pedido' => $nextOrderNumber++, // Número de pedido secuencial
                'fecha_cierre' => now(), // Fecha y hora actual
                'costo_total' => $item->autopart->precio, // Precio de la autoparte
                'tipo_pago' => $request->forma_pago, // Forma de pago seleccionada
            ]);

            // Eliminar la autoparte del carrito
            $item->delete();
        }

        return redirect()->route('autopartes.index')->with('success', 'Compra realizada con éxito.');
    }
}
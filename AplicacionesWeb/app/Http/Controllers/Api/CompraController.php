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
        // Procesar la compra según la forma de pago seleccionada
        // Aquí puedes agregar lógica adicional para procesar la compra

        // Obtener todos los productos en el carrito
        $carritoItems = Carrito::with('autopart')->get();

        // Crear un nuevo registro en la tabla pedidos
        $pedido = Pedido::create([
            'numero_pedido' => Pedido::max('id') + 1, // Generar un número de pedido único y ascendente
            'fecha_cierre' => now(), // Fecha y hora actual
            'costo_total' => $carritoItems->sum('autopart.precio'), // Sumar los precios de todas las autopartes en el carrito
            'tipo_pago' => $request->forma_pago, // Forma de pago seleccionada
        ]);

        foreach ($carritoItems as $item) {
            // Asignar el pedido a cada item del carrito
            $item->pedido_id = $pedido->id;
            $item->save();

            // Eliminar la autoparte del carrito
            $item->delete();
        }

        return redirect()->route('autopartes.index')->with('success', 'Compra realizada con éxito.');
    }
}
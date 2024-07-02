<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Autopart;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function pagar()
    {
        $carritoItems = Carrito::with('autoparte')->get();
        return view('carrito.pagar', compact('carritoItems'));
    }

    public function comprar(Request $request)
    {
        $carritoItems = Carrito::with('autoparte')->get();

        // Validar que forma_pago esté presente y no sea nulo
        $formaPago = $request->forma_pago ?? 'Pago no especificado'; // Ejemplo de valor por defecto si no se envía forma_pago

        // Crear el pedido
        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'fecha_cierre' => now(),
            'costo_total' => $carritoItems->sum('autopart.precio'),
            'tipo_pago' => $formaPago,  // Asignar forma_pago verificada o valor por defecto
        ]);

        // Crear los detalles del pedido
        foreach ($carritoItems as $item) {
            if ($item->autoparte && isset($item->autoparte->precio)) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'autoparte' => $item->autoparte->autoparte,
                    'marca' => $item->autoparte->marca,
                    'modelo' => $item->autoparte->modelo,
                    'codigo' => $item->autoparte->codigo,
                    'precio' => $item->autoparte->precio,
                ]);

                // Eliminar la autoparte del listado de autopartes
                $item->autoparte->delete();
            }

            // Eliminar el item del carrito
            $item->delete();
        }

        return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Compra realizada con éxito.');
    }

}
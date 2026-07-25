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
    //Crear los detalles del pedido, eliminar la autoparte del carrito y actualizar el stock de la autoparte
    public function procesarCompra(Request $request)
    {
        $request->validate([
            'forma_pago' => 'required|string'
        ]);

        $carritoItems = Carrito::where('user_id', Auth::id())
            ->with('autopart')
            ->get();

        if ($carritoItems->isEmpty()) {
            return response()->json([
                'message' => 'El carrito está vacío'
            ], 400);
        }

        $total = 0;

        foreach ($carritoItems as $item) {
            $total += $item->autopart->precio * $item->stock;
        }
        //El nombre de las columnas del pedido
        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'fecha_cierre' => now(),
            'costo_total' => $total,
            'tipo_pago' => $request->forma_pago,
        ]);

        foreach ($carritoItems as $item) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'autoparte' => $item->autopart->autoparte,
                'marca' => $item->autopart->marca,
                'modelo' => $item->autopart->modelo,
                'codigo' => $item->autopart->codigo,
                'precio' => $item->autopart->precio,
                'cantidad' => $item->stock,
            ]);

            // Descontar stock
            $autopart = Autopart::find($item->autopart_id);

            if ($autopart) {

                if ($autopart->stock < $item->stock) {
                    return response()->json([
                        'message' => 'Stock insuficiente para ' . $autopart->autoparte
                    ], 400);
                }

                $autopart->stock -= $item->stock;
                $autopart->save();
            }

        }


        //Vaciar carrito
        Carrito::where('user_id', Auth::id())->delete();

        return response()->json([
            'message' => 'Compra procesada con éxito',
            'pedido_id' => $pedido->id
        ]);
    }

}
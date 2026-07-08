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
    public function procesarCompra(Request $request){
        $carritoItems = Carrito::where('user_id', Auth::id())->with('autopart')->get();

        if ($carritoItems->isEmpty()) {
            return response()->json(['message' => 'El carrito está vacío'], 400);
        }

        $total = 0;
        foreach ($carritoItems as $item) {
            $total += $item->autopart->precio * $item->stock;
        }

        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'estado' => 'pendiente',
        ]);

        foreach ($carritoItems as $item) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'autopart_id' => $item->autopart_id,
                'stock' => $item->stock,
                'precio_unitario' => $item->autopart->precio,
            ]);

            // Actualizar el stock de la autoparte
            $autopart = Autopart::find($item->autopart_id);
            if ($autopart) {
                $autopart->stock -= $item->stock;
                $autopart->save();
            }
        }

        Carrito::where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Compra procesada con éxito', 'pedido_id' => $pedido->id]);
    }

}
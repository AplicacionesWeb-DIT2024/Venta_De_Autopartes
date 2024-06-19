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
    public function pagar()
    {
        $carritoItems = Carrito::with('autopart')->get();
        return view('carrito.pagar', compact('carritoItems'));
    }

    


public function comprar(Request $request)
{
    // Obtener todos los productos en el carrito
    $carritoItems = Carrito::with('autopart')->get();

    // Crear un nuevo pedido y asociar los detalles de pedido
    $pedido = Pedido::create([
        'numero_pedido' => uniqid(), // Generar un número de pedido único
        'fecha_cierre' => now(), // Fecha y hora actual
        'costo_total' => $carritoItems->sum('autopart.precio'), // Suma total de los precios
        'tipo_pago' => $request->forma_pago, // Forma de pago seleccionada
    ]);

    // Guardar los detalles de los productos asociados al pedido
    foreach ($carritoItems as $item) {
        $pedido->detalles()->create([
            'autoparte' => $item->autopart->autoparte,
            'marca' => $item->autopart->marca,
            'modelo' => $item->autopart->modelo,
            'codigo' => $item->autopart->codigo,
            'precio' => $item->autopart->precio,
        ]);
    }

    // Eliminar todos los productos del carrito
    Carrito::truncate();

    return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Compra realizada con éxito.');
}
}
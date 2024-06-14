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

        // Guardar los pedidos en la tabla pedidos y eliminar las autopartes y el carrito de la base de datos
        foreach ($carritoItems as $item) {
            // Crear un nuevo registro en la tabla pedidos
            Pedido::create([
                'autoparte' => $item->autopart->autoparte,
                'marca' => $item->autopart->marca,
                'modelo' => $item->autopart->modelo,
                'codigo' => $item->autopart->codigo,
                'precio' => $item->autopart->precio,
            ]);

            // Eliminar la autoparte
            $item->autopart->delete();

            // Eliminar el item del carrito
            $item->delete();
        }

        return redirect()->route('autopartes.index')->with('success', 'Compra realizada con éxito.');
    }
}
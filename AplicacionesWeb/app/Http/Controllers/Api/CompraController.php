<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Autopart;

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

        // Eliminar las autopartes y el carrito de la base de datos
        foreach ($carritoItems as $item) {
            $item->autopart->delete();  // Eliminar la autoparte
            $item->delete();            // Eliminar el item del carrito
        }

        return redirect()->route('autopartes.index')->with('success', 'Compra realizada con éxito.');
    }
}
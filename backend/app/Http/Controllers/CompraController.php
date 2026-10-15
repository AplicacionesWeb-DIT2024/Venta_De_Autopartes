<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Autopart;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CompraController extends Controller
{
    public function pagar()
    {
        $carritoItems = Carrito::where( // Filtrar los elementos del carrito por el ID del usuario autenticado
            'user_id',
            Auth::id() // Obtener los elementos del carrito del usuario autenticado
        )->with('autopart')->get();

        if ($carritoItems->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        return view('compra.pagar', compact('carritoItems'));
    }

    public function comprar(Request $request)
    {
        $request->validate([
            'forma_pago' => 'required|string',
        ]);

        DB::transaction(function () use ($request) { // Iniciar una transacción
            $carritoItems = Carrito::where('user_id', Auth::id())
                ->with('autopart')
                ->get();

            if ($carritoItems->isEmpty()) {
                throw ValidationException::withMessages(['forma_pago' => 'Tu carrito está vacío.']);
            }

            foreach ($carritoItems as $item) {
                $autopart = Autopart::where('id', $item->autopart_id)->lockForUpdate()->first(); // Bloquear la fila para evitar condiciones de carrera


                if (!$autopart) {
                    throw ValidationException::withMessages(['forma_pago' => 'No se encontró una autoparte del carrito.']);
                }

                if ($autopart->stock < $item->stock) {
                    throw ValidationException::withMessages([
                        'forma_pago' => 'Stock insuficiente para ' . $autopart->autoparte,
                    ]);
                }
            }

            $total = $carritoItems->sum(fn($item) => $item->autopart->precio * $item->stock);

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
                    'marca' => $item->autpart->marca,
                    'modelo' => $item->autopart->modelo,
                    'codigo' => $item->autopart->codigo,
                    'precio' => $item->autopart->precio,
                    'cantidad' => $item->stock,
                ]);

                Autopart::find($item->autopart_id)->decrement('stock', $item->stock);
            }

            Carrito::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('pedidos.index')->with('success', 'Compra realizada con éxito.');
    }
}
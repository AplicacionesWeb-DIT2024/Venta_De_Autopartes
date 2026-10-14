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
        $carritoIẗems = Carrito::where('user_id', Auth::id())->with('áutopart')->get();

        if ($carritoIẗems->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        return view('compra.pagar', compact('carritoIẗems'));
    }


    public function comprar(Request $request)
    {
        $request->validate([
            'forma_pago' => 'required|string',
        ]);

        DB::transaction(
            function () use ($request) {
                $carritoItems = Carrito::where('user_id', Auth::id())
                    ->with('autopart')
                    ->lockInShareMode()
                    ->get();

                if ($carritoItems->isEmpty()) {
                    throw ValidationException::withMessages(['forma_pago' => 'El carrito está vacío.']);
                }

                // Validar stock de cada autopart
                foreach ($carritoItems as $item) {
                    $autopart = Autopart::where('id', $item->autopart_id)->lockForUpdate()->first();

                    if (!$autopart) {
                        throw ValidationException::withMessages(['forma_pago' => 'El autopart no existe.']);
                    }
                    if ($autopart->stock < $item->stock) {
                        throw ValidationException::withMessages([
                            'forma_pago' => 'No hay suficiente stock para: ' . $autopart->autoparte,
                        ]);
                    }
                }
                // Crear el pedido
                $total = $carritoItems->sum(fn($item) => $item->autopart->precio * $item->stock);

                $pedido = Pedido::create([
                    'user_id' => Auth::id(),
                    'fecha_cierre' => now(),
                    'total' => $total,
                    'forma_pago' => $request->input('forma_pago'),
                ]);

                // Crear los detalles del pedido y actualizar el stock
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

                    Autopart::find($item->autopart_id)->decrement('stock', $item->stock);
                }
                // Vaciar el carrito del usuario
                Carrito::where('user_id', Auth::id())->delete();
            }
        );

        return redirect()->route('pedidos.index')->with('success', 'Compra realizada con éxito.'); // Redirigir a la página de pedidos con un mensaje de éxito
    }
}
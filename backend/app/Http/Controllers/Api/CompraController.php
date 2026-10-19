<?php

namespace App\Http\Controller\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Autopart;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function procesarCompra(Request $request)
    {
        $request->validate([
            'forma_pago' => 'required|string'
        ]);

        try {
            $pedido = DB::transaction(function () use ($request) {

                $carritoItems = Carrito::where('user_id', Auth::id())
                    ->with('autoparts')
                    ->get();

                if ($carritoItems->isEmpty()) {
                    throw new \Exception('El carrito está vacío.');
                }

                // 1) Validar TODO el stock ANTES de empezar
                foreach ($carritoItems as $item) {
                    $autopart = Autopart::where('id', $item->autoparts_id)->lockForUpdate()->first();

                    if (!$autopart) {
                        throw new \Exception('No se encontró una autoparte del carrito');
                    }

                    if ($autopart->stock < $item->stock) {
                        throw new \Exception('Stock insuficiente para ' . $autopart->autoparte);
                    }
                }

                // 2) Total
                $total = 0;
                foreach ($carritoItems as $item) {
                    $total += $item->autopart->precio * $item->stock;
                }

                // 3) Crear pedido
                $pedido = Pedido::create([
                    'user_id' => Auth::id(),
                    'fecha_cierre' => now(),
                    'costo_total' => $total,
                    'tipo_pago' => $request->forma_pago,
                ]);

                // 4) Detalles + descuento del stock
                foreach ($carritoItems as $item) {
                    DetallePedido::create([
                        'pedido_id' => $pedido->id,
                        'autoparte' => $item->autopart->autoparte,
                        'marca' => $item->autopart->marca,
                        'modelo' => $item->autopart->modelo,
                        'codigo' => $item->autopart->codigo,
                        'precio' => $item->autopart->precio,
                        'cantidad' => $item->autopart->cantidad,
                    ]);

                    $autopart = Autopart::find($item->autopart_id);
                    $autopart->decrement('stock', $item->stock);
                    $autopart->refresh();

                    if ($autopart->stock <= 0) {
                        $autopart->delete();
                    }
                }

                // 5) Vaciar carrito
                Carrito::where('user_id', Auth::id())->delete();

                return $pedido;
            });

            return response()->json([
                'message' => 'Comrpa procesada con éxito.',
                'pedido_id' => $pedido->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
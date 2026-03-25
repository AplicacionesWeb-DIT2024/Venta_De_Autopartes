<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Autopart;
use Illuminate\Support\Facades\Auth;


class CarritoController extends Controller
{
    // Método para mostrar el carrito del usuario autenticado
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::id())->with('autopart')->get();
        return response()->json($carrito);
    }

    // Método para agregar una autoparte al carrito
    public function store(Request $request)
    {
        $validated = $request->validate([
            'autopart_id' => 'required|exists:autoparts,id',
            'cantidad' => 'required|integer|min:1',
        ]);
        $autopart = Autopart::find($validated['autopart_id']);
        $carritoItem = Carrito::where('user_id', Auth::id())
            ->where('autopart_id', $validated['autopart_id'])
            ->first();
        if ($carritoItem) {
            $nuevaCantidad = $carritoItem->cantidad + $validated['cantidad'];
            if ($nuevaCantidad > $autopart->stock) {
                return response()->json([
                    'message' => 'Cantidad solicitada excede el stock disponible'
                ], 400);
            }
            $carritoItem->cantidad = $nuevaCantidad;
            $carritoItem->save();
        } else {
            if ($validated['cantidad'] > $autopart->stock) {
                return response()->json([
                    'message' => 'Cantidad solicitada excede el stock disponible'
                ], 400);
            }
            $carritoItem = Carrito::create([
                'user_id' => Auth::id(),
                'autopart_id' => $validated['autopart_id'],
                'cantidad' => $validated['cantidad'],
            ]);
        }
        return response()->json($carritoItem, 201);
    }

    public function destroy($id)
    {
        $carritoItem = Carrito::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$carritoItem) {
            return response()->json(['message' => 'Elemento del carrito no encontrado'], 404);
        }
        $carritoItem->delete();
        return response()->json(['message' => 'Elemento del carrito eliminado']);
    }

    // Método para actualizar la cantidad de una autoparte en el carrito
    public function update(Request $request, $id)
    {
        // Validar la cantidad
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);
        // Buscar el elemento del carrito
        $carritoItem = Carrito::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$carritoItem) {
            return response()->json([
                'message' => 'Elemento del carrito no encontrado'
            ], 404);
        }
        // Obtener autoparte
        $autopart = Autopart::find($carritoItem->autopart_id);
        // Validar stock
        if ($validated['cantidad'] > $autopart->stock) {
            return response()->json([
                'message' => 'Cantidad solicitada excede el stock disponible'
            ], 400);
        }
        // Actualizar cantidad
        $carritoItem->cantidad = $validated['cantidad'];
        $carritoItem->save();
        // Resupuesta
        return response()->json($carritoItem);
    }

    // Método para vaciar el carrito del usuario autenticado
    public function clear()
    {
        Carrito::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Carrito vaciado']);
    }
}

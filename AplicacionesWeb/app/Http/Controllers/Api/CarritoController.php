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

        $carritoItem = Carrito::create([
            'user_id' => Auth::id(),
            'autopart_id' => $validated['autopart_id'],
            'cantidad' => $validated['cantidad'],
        ]);

        return response()->json($carritoItem, 201);
    }

    // Método para eliminar una autoparte del carrito
    public function destroy($id)
    {
        $carritoItem = Carrito::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$carritoItem) {
            return response()->json(['message' => 'Elemento del carrito no encontrado'], 404);
        }
        $carritoItem->delete();
        return response()->json(['message' => 'Elemento del carrito eliminado']);
    }
}

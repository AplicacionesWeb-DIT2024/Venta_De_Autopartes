<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::id())->with('autopart')->get();
        return view('carrito.carrito', compact('carrito'));
    }

    // Agregar un producto al carrito
    public function store(Request $request)
    {
        $request->validate([
            'autopart_id' => 'required|exists:autoparts,id', // Validar que el autopart_id exista en la tabla autoparts
        ]);

        // Verificar si el producto ya está en el carrito
        $existe = Carrito::where('user_id', Auth::id())
            ->where('autopart_id', $request->autopart_id)
            ->first();

        // Si el producto ya está en el carrito, redirigir con un mensaje de error
        if ($existe) {
            return redirect()->back()->with('error', 'El producto ya está en el carrito.');
        }

        // Verificar si hay stock disponible para el producto
        $autopart = Autopart::find($request->autopart_id);
        if ($autopart->stock < 1) {
            return redirect()->back()->with('error', 'No hay stock disponible para este producto.');
        }

        // Agregar el producto al carrito
        Carrito::create([
            'user_id' => Auth::id(),
            'autopart_id' => $request->autopart_id,
            'stock' => 1, // Inicialmente se agrega 1 unidad al carrito
        ]);

        return redirect()->back()->with('success', 'Producto agregado al carrito.'); // Redirigir con un mensaje de éxito
    }

    // Eliminar un producto del carrito
    public function destroy($id)
    {
        $item = Carrito::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();
        return redirect()->route('carrito.index');
    }

    // Actualizar la cantidad de un producto en el carrito
    public function update(Request $request, $id)
    {
        $item = Carrito::where('id', $id)->where('user_id', Auth::id())->firstOrFail(); // Validar que el item exista y pertenezca al usuario autenticado

        $validated = $request->validate(['stock' => 'required|integer|min:1',]); // Validar que la cantidad sea un número entero mayor o igual a 1

        if ($validated['stock'] > $item->autopart->stock) { // Validar que la cantidad no exceda el stock disponible
            return redirect()->back()->with('error', 'La cantidad solicitada excede el stock disponible.');
        }

        $item->update(['stock' => $validated['stock']]); // Actualizar la cantidad en el carrito
        return redirect()->route('carrito.index');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Carrito;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CarritoController extends Controller
{
    // Método para mostrar el carrito del usuario autenticado
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::id())->with('autopart')->get();
        return view('carrito.carrito', compact('carrito')); // Retorna la vista con los elementos del carrito
    }

    // Método para agregar una autoparte al carrito
    public function store(Request $request)
    {
        $request->validate([
            'autopart_id' => 'required|exists:autoparts,id',
        ]);

        $existe = Carrito::where('user_id', Auth::id())
            ->where('autopart_id', $request->autopart_id)
            ->first();

        if ($existe) {
            return redirect()->back()->with('error', 'La autoparte ya está en el carrito.');
        }

        $autopart = Autopart::find($request->autopart_id);
        if ($autopart->stock < 1) {
            return redirect()->back()->with('error', 'No hay stock disponible para esta autoparte.');
        }

        Carrito::create([
            'user_id' => Auth::id(),
            'autopart_id' => $request->autopart_id,
            'cantidad' => 1, // Inicialmente se agrega una unidad
        ]);

        return redirect()->route('carrito.index');
    }

    public function destroy($id)
    {
        $item = Carrito::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();
        return redirect()->route('carrito.index');
    }

    // Método para actualizar la cantidad de una autoparte en el carrito
    public function update(Request $request, $id)
    {
        $item = Carrito::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $validated = $request->validate(['stock' => 'required|integer|min:1']);

        if ($validated['stock']->$item->autopart->stock) {
            return redirect()->back()->with('error', 'La cantidad solicitada excede el stock disponible.');
        }

        $item->update(['stock' => $validated['stock']]);
        return redirect()->route('carrito.index');
    }
}
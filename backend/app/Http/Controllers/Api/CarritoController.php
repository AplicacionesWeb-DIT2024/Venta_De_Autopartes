<?php

namespace App\Http\Controllers;

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
        return view('carrito.carrito', compact('carrito'));
    }

    // Método para agregar una autoparte al carrito
    public function store(Request $request)
    {
        // Validar que la autoparte existe y que el usuario está autenticado
        $request->validate([
            'autopart_id' => 'required|exists:autoparts,id',
        ]);

        // Verificar si la autoparte ya está en el carrito del usuario
        $existe = Carrito::where('user_id', Auth::id())
            ->where('autopart_id', $request->autopart_id)
            ->first();

        // Verificar si la autoparte ya está en el carrito del usuario
        if ($existe) {
            return redirect()->back()->with('error', 'La autoparte ya está en el carrito.');
        }

        // Verificar si hay stock disponible para la autoparte
        $autopart = Autopart::find($request->autopart_id);
        if ($autopart->stock < 1) {
            return redirect()->back()->with('error', 'No hay stock disponible para esta autoparte.');
        }

        // Agregar la autoparte al carrito del usuario
        Carrito::create([
            'user_id' => Auth::id(),
            'autopart_id' => $request->autopart_id,
            'stock' => 1,
        ]);

        return redirect()->route('carrito.index'); // Redirigir al carrito después de agregar la autoparte
    }

    // Método para eliminar una autoparte del carrito
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

        // Verificar si hay suficiente stock disponible para la autoparte
        if ($validated['stock'] > $item->autopart->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para esta autoparte.');
        }

        $item->update(['stock' => $validated['stock']]);
        return redirect()->route('carrito.index');
    }
}

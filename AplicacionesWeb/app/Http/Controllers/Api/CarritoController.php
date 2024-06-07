<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Autopart;

class CarritoController extends Controller
{
    public function index()
    {
        // Obtener todos los elementos del carrito
        $carritoItems = Carrito::with('autopart')->get();

        // Pasar los elementos a la vista
        return view('carrito.carrito', compact('carritoItems'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'autopart_id' => 'required|exists:autoparts,id',
        ]);

        // Verificar si la autoparte ya está en el carrito
        $existingItem = Carrito::where('autopart_id', $request->autopart_id)->first();

        if ($existingItem) {
            // Incrementar la cantidad si ya existe
            $existingItem->increment('cantidad');
        } else {
            // Agregar la autoparte al carrito
            Carrito::create([
                'autopart_id' => $request->autopart_id,
                'cantidad' => 1
            ]);
        }

        // Redirigir al carrito con un mensaje de éxito
        return redirect()->route('carrito.index')->with('success', 'Autoparte agregada al carrito');
    }
}
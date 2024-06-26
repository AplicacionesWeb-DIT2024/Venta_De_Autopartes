<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\Models\Carrito;
use App\Models\Autopart;


class CarritoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Cliente')->except('index', 'show');
    }
    public function index()
    {
        // Obtener todos los ítems del carrito
        $carritoItems = Carrito::with('autopart')->get();

        // Pasar los ítems del carrito a la vista
        return view('carrito.carrito', compact('carritoItems'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'autopart_id' => 'required|exists:autopart,id',
        ]);

        // Buscar un ítem existente en el carrito
        $existingItem = Carrito::where('autopart_id', $request->autopart_id)->first();

        if ($existingItem) {
            // Actualizar la cantidad si el ítem ya existe en el carrito
            $existingItem->quantity += 1; // o la cantidad deseada
            $existingItem->save();
        } else {
            // Crear un nuevo ítem en el carrito
            Carrito::create([
                'autopart_id' => $request->autopart_id,
                'quantity' => 1, // o la cantidad deseada
            ]);
        }

        // Redirigir al carrito con un mensaje de éxito
        return redirect()->route('carrito.index')->with('success', 'Autoparte agregada al carrito');
    }

    public function show($id)
    {
        $autopart = Autopart::findOrFail($id);
        return view('autopartes.producto', compact('autopart'));
    }


    public function destroy($id)
    {
        $item = Carrito::find($id);
        if ($item) {
            $item->delete();
        }
        return redirect()->route('carrito.index')->with('success', 'Item eliminado del carrito.');
    }


}
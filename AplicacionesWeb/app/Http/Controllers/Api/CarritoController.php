<?php

namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CarritoController extends Controller
{
    public function index()
{
    $carritoItems = Carrito::with('autopart')->get();

    return view('carrito.index', compact('carritoItems'));
}


    public function create()
{
    $autoparts = Autopart::all(); // Obtener todas las autopartes
    return view('carrito.create', compact('autoparts'));
}


public function store(Request $request)
{
    // Validar la solicitud
    $request->validate([
        'autopart_id' => 'required|exists:autoparts,id',
    ]);

    // Verificar si la autoparte ya está en el carrito
    $existingItem = CarritoController::where('autopart_id', $request->autopart_id)->first();

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


   

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $autoparts = Autopart::orderBy('id')->get();
        return view('carrito.edit', compact('pedido', 'autoparts'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'autoparte' => 'required|exists:autoparts,autoparte',
            'cantidad' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $autoparte = Autopart::where('autoparte', $request->autoparte)->firstOrFail();

        $pedido->autoparte = $autoparte->autoparte;
        $pedido->precio = $autoparte->precio;
        $pedido->cantidad = $request->cantidad;
        $pedido->save();

        return redirect()->route('carrito.index')->with('success', 'Pedido actualizado con éxito');
    }

    public function destroy($id)
{
    $carritoItem = Carrito::findOrFail($id);
    $carritoItem->delete();

    return redirect()->route('carrito.index')->with('success', 'Autoparte eliminada del carrito');
}


    public function show($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            $data = [
                'message' => 'Pedido no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'pedido' => $pedido,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Autopart;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{

    public function index()
    {
        $carrito = Carrito::with('autopartes')->where('user_id', Auth::id())->first();
        return view('carrito.carrito', compact('carrito'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'autopart_id' => 'required|exists:autopart,id',
        ]);

        $existingItem = Carrito::where('autopart_id', $request->autopart_id)->where('user_id', Auth::id())->first();

        if ($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            Carrito::create([
                'autopart_id' => $request->autopart_id,
                'user_id' => Auth::id(),
                'quantity' => 1,
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Autoparte agregada al carrito');
    }

    public function show($id)
    {
        $autopart = Autopart::findOrFail($id);
        return view('autopartes.producto', compact('autopart'));
    }

    public function destroy($id)
    {
        $item = Carrito::where('id', $id)->where('user_id', Auth::id())->first();
        if ($item) {
            $item->delete();
        }
        return redirect()->route('carrito.index')->with('success', 'Item eliminado del carrito.');
    }
}
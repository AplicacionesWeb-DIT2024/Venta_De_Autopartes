<?php

namespace App\Http\Controllers\Api;

use App\Models\Autopart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutopartController extends Controller
{

    // Método para mostrar todas las autopartes
    public function index()
    {
        $autoparts = Autopart::all();
        return response()->json($autoparts);
    }

    // Método para mostrar una autoparte específica
    public function show($id)
    {
        $autopart = Autopart::find($id);
        if ($autopart) {
            return response()->json($autopart);
        } else {
            return response()->json(['message' => 'Autoparte no encontrada'], 404);
        }
    }

    // Método para crear una nueva autoparte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'añoVehiculo' => 'required|integer',
            'codigo' => 'required|string|max:255|unique:autoparts',
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'color' => 'required|string|max:255',
        ]);
        $autopart = Autopart::create($validated);
        return response()->json($autopart, 201);
    }

    // Método para actualizar una autoparte
    public function update(Request $request, $id)
    {
        $autopart = Autopart::find($id);
        if ($autopart) {
            $autopart->update($request->all());
            return response()->json($autopart);
        } else {
            return response()->json(['message' => 'Autoparte no encontrada'], 404);
        }
    }

    // Método para eliminar una autoparte
    public function destroy($id)
    {
        $autopart = Autopart::find($id);
        if (!$autopart) {
            return response()->json(['message' => 'Autoparte no encontrada'], 404);
        }
        $autopart->delete();
        return response()->json(['message' => 'Autoparte eliminada']);
        
    }
}

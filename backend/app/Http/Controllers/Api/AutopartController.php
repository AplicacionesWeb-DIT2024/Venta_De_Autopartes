<?php

namespace App\Http\Controllers;

use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutopartController extends Controller
{

    public function index()
    {
        $autoparts = Autopart::orderBy('created_at', 'desc')->get();
        return view('autopates.autopartes', compact('autoparts'));
    }

    public function create()
    {
        return view('autoparts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'),
            'codigo' => 'required|string|max:255|unique:autoparts,codigo',
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
        ]);

        Autopart::create($validated);

        return redirect()->route('autopartes.index')->with('success', 'Autoparte creada exitosamente.');
    }

    public function show($id)
    {
        $autopart = Autopart::findOrFail($id);
        return view('autoparts.producto', compact('autopart'));
    }

    public function edit($id)
    {
        $autopart = Autopart::findOrFail($id);
        return view('autoparts.edit', compact('autopart'));
    }

    public function update(Request $request, $id)
    {
        $autopart = Autopart::findOrFail($id);

        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'),
            'codigo' => ['required', 'string', 'max:255', Rule::unique('autoparts')->ignore($autopart->id)],
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
        ]);

        $autopart->update($validated);

        return redirect()->route('autopartes.index')->with('success', 'Autoparte actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $autopart = Autopart::findOrFail($id);
        $autopart->delete();

        return redirect()->route('autopartes.index')->with('success', 'Autoparte eliminada exitosamente.');
    }
}

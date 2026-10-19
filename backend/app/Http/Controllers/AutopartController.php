<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Importa la clase Rule para validar reglas de unicidad en la actualización de autopartes

class AutopartController extends Controller
{
    public function index()
    {
        $autoparts = Autopart::orderBy('created_at', 'desc')->get(); // Obtiene todas las autopartes ordenadas por fecha de creación en orden descendente
        return view('autopartes.autopartes', compact('autoparts')); // Retorna la vista con la lista de autopartes
    }

    public function create()
    {
        return view('autopartes.create'); // Retorna la vista para crear un nuevo autoparte
    }

    // Almacena una nueva autoparte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'),
            'codigo' => 'required|string|max:255|unique:autoparts,codigo', // Acá no usa Rule porque es una creación, no una actualización
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:0|max:99',
        ]);

        Autopart::create($validated);

        return redirect()->route('autopartes.index')->with('success', 'Autoparte creada exitosamente.');
    }

    public function show($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por su ID o lanza un error 404 si no se encuentra
        return view('autopartes.show', compact('autopart')); // Retorna la vista con los detalles de la autoparte
    }

    public function edit($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por su ID o lanza un error 404 si no se encuentra
        return view('autopartes.edit', compact('autopart')); // Retorna la vista para editar la autoparte
    }

    public function update(Request $request, $id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por su ID o lanza un error 404 si no se encuentra

        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'),
            'codigo' => ['required', 'string', 'max:255', Rule::unique('autoparts')->ignore($id)], // Asegura que el código sea único, ignorando el registro actual
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:0|max:99',
        ]);

        $autopart->update($validated); // Actualiza la autoparte con los datos validados

        return redirect()->route('autopartes.index')->with('success', 'Autoparte actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por su ID o lanza un error 404 si no se encuentra

        if (is_array($autopart->foto)) {
            foreach ($autopart->foto as $foto) {
                Storage::disk('public')->delete($foto); // Elimina cada foto asociada a la autoparte del almacenamiento
            }
        }

        $autopart->delete(); // Elimina la autoparte

        return redirect()->route('autopartes.index')->with('success', 'Autoparte eliminada exitosamente.');
    }
}

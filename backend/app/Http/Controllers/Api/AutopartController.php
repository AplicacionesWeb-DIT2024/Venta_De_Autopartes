<?php

namespace App\Http\Controllers;

use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AutopartController extends Controller
{
    // Método para obtener todas las autopartes
    public function index(Request $request)
    {
        $autoparts = Autopart::orderBy('created_at', 'desc')->get(); // Obtiene todas las autopartes ordenadas por fecha de creación en orden descendente
        return view('autopartes.autopartes', compact('autoparts')); // Devuelve la vista 'autopartes.autopartes' con las autopartes obtenidas
    }

    public function create()
    {
        return view('autopartes.create'); // Devuelve la vista 'autopartes.create' para crear una nueva autoparte
    }

    // Método para almacenar una nueva autoparte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'), // Valida que el año del vehículo sea un número entero entre 1900 y el año actual
            'codigo' => 'required|string|max:255|unique:autoparts,codigo', // Valida que el código sea único en la tabla autoparts, ignorando el registro actual en caso de actualización
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:1|max:99', // Valida que el stock sea un número entero entre 1 y 99
        ]);

        Autopart::create($validated); // Crea una nueva autoparte con los datos validados

        return redirect()->route('autopartes.index')->with('success', 'Autoparte creada exitosamente.'); // Redirige a la ruta 'autopartes.index' con un mensaje de éxito
    }

    // Método para mostrar una autoparte específica
    public function show($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra
        return view('autopartes.producto', compact('autopart')); // Devuelve la vista 'autopartes.producto' con la autoparte obtenida
    }

    public function edit($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra
        return view('autopartes.edit', compact('autopart')); // Devuelve la vista 'autopartes.edit' con la autoparte obtenida
    }

    // Método para actualizar una autoparte
    public function update(Request $request, $id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra

        $validated = $request->validate([ // Valida los datos de entrada para la actualización de la autoparte
            'autoparte' => 'sometimes|required|string|max:255',
            'marca' => 'sometimes|required|string|max:255',
            'modelo' => 'sometimes|required|string|max:255',
            'anioVehiculo' => 'sometimes|required|integer',
            'codigo' => ['required', 'string', 'max:255', Rule::unique('autoparts')->ignore($id)],
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'sometimes|required|string|max:255',
            'stock' => 'required|integer|min:1|max:99',
        ]);

        $autopart->update($validated); // Actualiza la autoparte con los datos validados

        return redirect()->route('autopartes.index')->with('success', 'Autoparte actualizada exitosamente.'); // Redirige a la ruta 'autopartes.index' con un mensaje de éxito
    }

    // Método para eliminar una autoparte
    public function destroy($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra

        // Elimina las fotos asociadas a la autoparte del almacenamiento público
        if (is_array($autopart->foto)) {
            foreach ($autopart->foto as $foto) {
                Storage::disk('public')->delete($foto); // Elimina la foto de la autoparte del almacenamiento público
            }
        }

        $autopart->delete(); // Elimina la autoparte

        return redirect()->route('autopartes.index')->with('success', 'Autoparte eliminada exitosamente.'); // Redirige a la ruta 'autopartes.index' con un mensaje de éxito
    }
}

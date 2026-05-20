<?php

namespace App\Http\Controllers\Api;

use App\Models\Autopart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AutopartController extends Controller
{

    // Método para mostrar todas las autopartes
    public function index(Request $request)
    {
        // Obtener el parámetro per_page, por defecto 50
        $perPage = $request->input('per_page', 50);
        
        // Validar que per_page no sea mayor a 100 (seguridad)
        if ($perPage > 100) {
            $perPage = 100;
        }
        
        return Autopart::orderBy('created_at', 'desc')->paginate($perPage); // Devuelve una lista paginada de autopartes ordenadas por fecha de creación en orden descendente
    }

    // Método para mostrar una autoparte específica
    public function show($id)
    {
        return response()->json(Autopart::findOrFail($id)); // Busca la autoparte por ID o lanza una excepción si no se encuentra, y devuelve la autoparte en formato JSON
    }

    // Método para crear una nueva autoparte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'autoparte' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anioVehiculo' => 'required|integer|min:1900|max:' . date('Y'), // Valida que el año del vehículo sea un número entero entre 1900 y el año actual
            'codigo' => 'required|string|max:255|unique:autoparts,codigo', // Valida que el código sea único en la tabla autoparts, ignorando el registro actual en caso de actualización
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'color' => 'required|string|max:255',
        ]);
        $autopart = Autopart::create($validated);
        return response()->json($autopart, 201);
    }

    // Método para actualizar una autoparte
    public function update(Request $request, $id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra
        $validated = $request->validate([ // Valida los datos de entrada para la actualización de la autoparte
            'autoparte' => 'sometimes|required|string|max:255',
            'marca' => 'sometimes|required|string|max:255',
            'modelo' => 'sometimes|required|string|max:255',
            'añoVehiculo' => 'sometimes|required|integer',
            'codigo' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('autoparts')->ignore($id), 
            ],
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'color' => 'sometimes|required|string|max:255',
        ]);
        $autopart->update($validated); // Actualiza la autoparte con los datos validados
        return response()->json($autopart); // Devuelve la autoparte actualizada en formato JSON
    }

    // Método para eliminar una autoparte
    public function destroy($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra
        $autopart->delete(); // Elimina la autoparte
        return response()->json(null, 204);// Devuelve una respuesta sin contenido con el código de estado 204
    }
}

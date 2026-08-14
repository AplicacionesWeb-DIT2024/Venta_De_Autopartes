<?php

namespace App\Http\Controllers\Api;

use App\Models\Autopart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
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

        // El listado se cachea 60 segundos para evitar la latencia y el
        // arranque en frío de la base de datos remota. Se invalida al crear,
        // actualizar o eliminar una autoparte.
        return Cache::remember("autoparts.page.$perPage", 60, function () use ($perPage) {
            // Estas son las columnas que voy a mostrar en el frontend.
            return Autopart::select(
                'id',
                'autoparte',
                'marca',
                'modelo',
                'precio',
                'estado',
                'anioVehiculo',
                'codigo',
                'color',
                'stock',
                'foto',
                'created_at'
            )
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
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
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'required|string|max:255',
            'stock' => 'required|integer|min:1|max:99', // Valida que el stock sea un número entero entre 1 y 99
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120' // Valida que la foto sea una imagen obligatoria con un tamaño máximo de 5MB
        ]);

        // Si se proporciona una foto, se almacena en el disco público y se guarda la ruta en la base de datos
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request
                ->file('foto')
                ->store('autoparts', 'public'); // Almacena la foto en el disco público y guarda la ruta en la base de datos
        }

        $autopart = Autopart::create($validated);

        Cache::forget("autoparts.page.50");
        Cache::forget("autoparts.page.100");

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
            'anioVehiculo' => 'sometimes|required|integer',
            'codigo' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('autoparts')->ignore($id),
            ],
            'estado' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:5000000',
            'color' => 'sometimes|required|string|max:255',
            'stock' => 'required|integer|min:1|max:99'
        ]);

        $autopart->update($validated); // Actualiza la autoparte con los datos validados

        Cache::forget("autoparts.page.50");
        Cache::forget("autoparts.page.100");

        return response()->json($autopart); // Devuelve la autoparte actualizada en formato JSON
    }

    // Método para eliminar una autoparte
    public function destroy($id)
    {
        $autopart = Autopart::findOrFail($id); // Busca la autoparte por ID o lanza una excepción si no se encuentra

        $autopart->delete(); // Elimina la autoparte

        Cache::forget("autoparts.page.50");
        Cache::forget("autoparts.page.100");

        return response()->json(null, 204);// Devuelve una respuesta sin contenido con el código de estado 204
    }
}

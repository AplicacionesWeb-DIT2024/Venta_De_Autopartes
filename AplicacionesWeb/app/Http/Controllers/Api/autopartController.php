<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class autopartController extends Controller
{
    public function index()
    {
        $autopart = Autopart::all();

        $data = [
            'autopart' => $autopart,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'añoVehiculo' => 'required|digits:4',
            'codigo' => 'required|max:10',
            'estado' => 'required|in:Muy bueno,Bueno,Malo,Muy malo',
            'precio' => 'required|numeric|between:0,5000000',
            'color' => 'required|max:15'
        ]);
        

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $autopart = Autopart::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'añoVehiculo' => $request->añoVehiculo,
            'codigo' => $request->codigo,
            'estado' => $request->estado,
            'precio' => $request->precio,
            'color' => $request->color,
        ]);

        if (!$autopart) {
            $data = [
                'message' => 'Error al crear la autoparte',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'autopart' => $autopart,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id)
    {
        $autopart = Autopart::find($id);

        if (!$autopart) {
            $data = [
                'message' => 'Autoparte no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'autopart' => $autopart,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $autopart = Autopart::find($id);

        if (!$autopart) {
            $data = [
                'message' => 'Autoparte no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $autopart->delete();

        $data = [
            'message' => 'Autoparte eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $autopart = Autopart::find($id);

        if (!$autopart) {
            $data = [
                'message' => 'Autoparte no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'añoVehiculo' => 'required|digits:4',
            'codigo' => 'required|max:10',
            'estado' => 'required|in:Muy bueno,Bueno,Malo,Muy malo',
            'precio' => 'required|numeric|between:0,5000000',
            'color' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $autopart->marca = $request->marca;
        $autopart->modelo = $request->modelo;
        $autopart->añoVehiculo = $request->añoVehiculo;
        $autopart->codigo = $request->codigo;
        $autopart->estado = $request->estado;
        $autopart->precio = $request->precio;
        $autopart->color = $request->color;

        $autopart->save();

        $data = [
            'message' => 'Autoparte actualizada',
            'autopart' => $autopart,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function updatePartial(Request $request, $id)
    {
        $autopart = Autopart::find($id);

        if (!$autopart) {
            $data = [
                'message' => 'Autoparte no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'añoVehiculo' => 'required|digits:4',
            'codigo' => 'required|max:10',
            'estado' => 'required|in:Muy bueno,Bueno,Malo,Muy malo',
            'precio' => 'required|numeric|between:0,5000000',
            'color' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('marca')) {
            $autopart->marca = $request->marca;
        }

        if ($request->has('modelo')) {
            $autopart->modelo = $request->modelo;
        }

        if ($request->has('añoVehiculo')) {
            $autopart->añoVehiculo = $request->añoVehiculo;
        }

        if ($request->has('codigo')) {
            $autopart->codigo = $request->codigo;
        }

        if ($request->has('estado')) {
            $autopart->estado = $request->estado;
        }

        if ($request->has('precio')) {
            $autopart->precio = $request->precio;
        }

        if ($request->has('color')) {
            $autopart->color = $request->color;
        }

        $autopart->save();

        $data = [
            'message' => 'Autoparte actualizada',
            'autopart' => $autopart,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

}
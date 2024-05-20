<?php

namespace App\Http\Controllers;

use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutopartController extends Controller
{
    public function create()
    {
        return view('autoparts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'autoparte' => 'required|max:255',
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'añoVehiculo' => 'required|digits:4',
            'codigo' => 'required|max:10',
            'estado' => 'required|in:Muy bueno,Bueno,Malo,Muy malo',
            'precio' => 'required|numeric|between:0,5000000',
            'color' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $autopart = Autopart::create($request->all());

        if (!$autopart) {
            return redirect()->back()->with('error', 'Error al crear la autoparte');
        }

        return redirect()->route('autoparts.create')->with('success', 'Autoparte creada exitosamente');
    }

    public function index()
    {
        $autopart = Autopart::all();

        $data = [
            'autopart' => $autopart,
            'status' => 200
        ];

        return response()->json($data, 200);
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
            'autoparte' => 'required|max:255',
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

        $autopart->autoparte = $request->autoparte;
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
            'autoparte' => 'required|max:255',
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

        if ($request->has('autoparte')) {
            $autopart->autoparte = $request->autoparte;
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
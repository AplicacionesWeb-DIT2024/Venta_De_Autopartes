<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado
use App\Models\Pedido;
use Illuminate\Support\Facades\DB; // Para manejar transacciones
use App\Models\Autopart;
use Illuminate\Validation\ValidationException; // Para manejar errores de validación

class PedidoController extends Controller
{// Método para mostrar los pedidos del usuario autenticado
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->with('detalles')->get();
        return response()->json($pedidos);
    }

    // Método para mostrar los detalles de un pedido específico
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('detalles')
            ->firstOrFail();
        return response()->json($pedido);
    }

    // Método para crear un nuevo pedido
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,procesando,enviado,entregado',
            'detalles' => 'required|array',
            'detalles.*.autopart_id' => 'required|exists:autoparts,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
        ]);
        $pedido = DB::transaction(function () use ($validated) {
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => 0,
                'estado' => $validated['estado'],
            ]);
            $total = 0;
            $autopartIds = collect($validated['detalles'])->pluck('autopart_id');
            $ids = collect($validated['detalles'])->pluck('autopart_id');
            if ($ids->duplicates()->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'detalles' => 'No se pueden repetir autopartes en un mismo pedido.']
                );
            }
            $autoparts = Autopart::whereIn('id', $autopartIds)
                ->get()
                ->keyBy('id');

            foreach ($validated['detalles'] as $detalle) {
                $autopart = $autoparts->get($detalle['autopart_id']);
                if (!$autopart) {
                    throw new \Exception('Autoparte no encontrada: ID ' . $detalle['autopart_id']);
                }
                $subtotal = $autopart->precio * $detalle['cantidad'];
                $total += $subtotal;
                $pedido->detalles()->create([
                    'autopart_id' => $detalle['autopart_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $autopart->precio,
                ]);
            }
            $pedido->update([
                'total' => $total
            ]);
            return $pedido->load('detalles');
        });
        return response()->json($pedido, 201);
    }

    // Método para editar pedido
    public function update(Request $request, $id)
    {
        $pedido = Pedido::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $validated = $request->validate([
            'estado' => 'in:pendiente,procesando,enviado,entregado',
        ]);
        $pedido->update($validated);
        return response()->json($pedido);
    }

    // Método para eliminar pedido
    public function destroy($id)
    {
        $pedido = Pedido::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pedido->detalles()->delete(); // Eliminar los detalles del pedido antes de eliminar el pedido
        $pedido->delete(); // Eliminar el pedido
        return response()->json(['message' => 'Pedido eliminado']);
    }
}

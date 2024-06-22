<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\DetallePedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderByDesc('created_at')->get();

        return view('pedidos.pedidos', compact('pedidos'));
    }


    public function show($id)
{
    $pedido = Pedido::findOrFail($id);
    $detalles = DetallePedido::where('pedido_id', $pedido->id)->get();

    return view('pedidos.detalle', compact('pedido', 'detalles'));
}

}
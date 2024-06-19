<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use App\Models\Autopart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderByDesc('created_at')->get();

        return view('pedidos.index', compact('pedidos'));
    }


    public function show($id)
    {
        $pedido = Pedido::with('carritoItems.autopart')->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }
}
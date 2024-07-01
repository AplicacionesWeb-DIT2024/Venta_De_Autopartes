@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Pedidos</h1>
    <div class="text-right mr-3">
        <p class="mb-1"><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
        <p class="mb-1"><strong>Rol:</strong> <span
                class="badge badge-info">{{ Auth::user()->role == 'Empleado' ? 'Empleado' : 'Cliente' }}</span>
        </p>
    </div>
    @if($pedidos->isEmpty())
        <p>No tienes pedidos.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->created_at }}</td>
                        <td>
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info">Ver Detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Ir al listado de autopartes</a>
    <a href="{{ route('carrito.index') }}" class="btn btn-secondary">Volver al Carrito</a>
</div>
@endsection
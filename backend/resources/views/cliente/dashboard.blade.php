@extends('layouts.app')

@section('sec')
    <div class="container mt-5">
        <h1>Panel de Cliente</h1>
        <p>Bienvenido, {{ Auth::user()->name }}</p>
        <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Ver Autopartes</a>
        <a href="{{ route('carrito.index') }}" class="btn btn-success">Ir al Carrito</a>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Mis Pedidos</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <h1>Bienvenido</h1>
    <form method="GET" action="{{ route('cliente') }}">
        <input type="hidden" name="key" value="cliente">
        <button type="submit">Acceso Cliente</button>
    </form>

    <form method="GET" action="{{ route('empleado') }}">
        <input type="hidden" name="key" value="empleado">
        <button type="submit">Acceso Empleado</button>
    </form>
@endsection

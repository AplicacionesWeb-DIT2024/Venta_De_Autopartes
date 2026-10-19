@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Panel de Empleado</h1>
        <p>Bienvenido, {{ Auth::user()->name }}</p>
        <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Gestionar Autopartes</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
@endsection
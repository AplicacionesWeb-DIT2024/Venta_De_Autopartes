@extends('layouts.app')

@section('content')
    <h1>Editar Pedido</h1>
    <form action="{{ route('carrito.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="autoparte">Autoparte</label>
        <select name="autoparte" id="autoparte">
            @foreach ($autoparts as $autopart)
                <option value="{{ $autopart->autoparte }}" {{ $pedido->autoparte == $autopart->autoparte ? 'selected' : '' }}>{{ $autopart->autoparte }}</option>
            @endforeach
        </select>
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" value="{{ $pedido->cantidad }}">
        <button type="submit">Actualizar</button>
    </form>
@endsection
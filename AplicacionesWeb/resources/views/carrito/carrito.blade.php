<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Carrito</h1>
            <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Agregar Otro Producto</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if($carrito->count() > 0)
                        @foreach ($carrito as $item)
                            <tr>
                                <td>{{ $item->autoparte->autoparte }}</td>
                                <td>{{ $item->autoparte->marca }}</td>
                                <td>{{ $item->autoparte->modelo }}</td>
                                <td>{{ $item->autoparte->codigo }}</td>
                                <td>{{ $item->autoparte->precio }}</td>
                                <td>
                                    <a href="{{ route('autopartes.show', $item->autoparte->id) }}"
                                        class="btn btn-info btn-sm">Ver
                                        Detalles</a>
                                    <form action="{{ route('carrito.destroy', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar del Carrito</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No tienes autopartes en tu carrito.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($carrito->count() > 0)
            <div class="d-flex justify-content-end">
                <h4>Subtotal: ${{ number_format($carrito->sum('autoparte.precio'), 2) }}</h4>
                <!-- Suma de todos los costos -->
            </div>
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('pagar') }}" class="btn btn-success">Proceder al Pago</a>
                <a href="{{ route('pedidos.index') }}" class="btn btn-primary ml-2">Ver Pedidos</a>
                <!-- Agregar botón para ver pedidos -->
            </div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
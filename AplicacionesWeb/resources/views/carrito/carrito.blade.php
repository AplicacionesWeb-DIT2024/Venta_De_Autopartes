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
                    @foreach ($carritoItems as $item)
                        <tr>
                            <td>{{ $item->autopart->autoparte }}</td>
                            <td>{{ $item->autopart->marca }}</td>
                            <td>{{ $item->autopart->modelo }}</td>
                            <td>{{ $item->autopart->codigo }}</td>
                            <td>{{ $item->autopart->precio }}</td>
                            <td>
                            <a href="{{ route('autopartes.show', $item->autopart->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                <form action="{{ route('carrito.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar del Carrito</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <h4>Subtotal: ${{ number_format($carritoItems->sum('autopart.precio'), 2) }}</h4> <!--Suma de todos los costos.-->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
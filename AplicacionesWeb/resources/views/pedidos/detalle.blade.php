<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Detalles del Pedido</h1>
        <p>Número de Pedido: {{ $pedido->numero_pedido }}</p>
        <p>Fecha de Cierre: {{ $pedido->fecha_cierre }}</p>
        <p>Costo Total: {{ $pedido->costo_total }}</p>
        <p>Tipo de Pago: {{ $pedido->tipo_pago }}</p>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Código</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedido->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->autoparte }}</td>
                            <td>{{ $detalle->marca }}</td>
                            <td>{{ $detalle->modelo }}</td>
                            <td>{{ $detalle->codigo }}</td>
                            <td>{{ $detalle->precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver al Listado de Pedidos</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
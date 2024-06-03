<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pedidos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Agregar Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Listado de Pedidos</h1>
            <!-- Botón para agregar nuevo pedido -->
            <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Agregar Otro Producto</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Autoparte</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th> <!-- Aquí podrías agregar botones de acción, por ejemplo, para editar o eliminar -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los pedidos, pero como inicialmente estará vacío, no habrá filas en la tabla -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agregar JS de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Aquí podrías agregar scripts adicionales si los necesitas -->
</body>
</html>
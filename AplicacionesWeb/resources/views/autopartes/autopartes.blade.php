<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Autopartes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Agregar Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Autopartes</h1>
            <a href="{{ route('autopartes.create') }}" class="btn btn-primary">Agregar Nueva Autoparte</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año Vehículo</th>
                        <th>Código</th>
                        <th>Estado</th>
                        <th>Precio</th>
                        <th>Color</th>
                        <th>Acciones</th> <!-- Nueva columna para los botones -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($autoparts as $autopart)
                        <tr>
                            <td>{{ $autopart->id }}</td>
                            <td>{{ $autopart->autoparte }}</td>
                            <td>{{ $autopart->marca }}</td>
                            <td>{{ $autopart->modelo }}</td>
                            <td>{{ $autopart->añoVehiculo }}</td>
                            <td>{{ $autopart->codigo }}</td>
                            <td>{{ $autopart->estado }}</td>
                            <td>{{ $autopart->precio }}</td>
                            <td>{{ $autopart->color }}</td>
                            <td>
                                <a href="{{ route('autopartes.edit', $autopart->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('autopartes.destroy', $autopart->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Agregar JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
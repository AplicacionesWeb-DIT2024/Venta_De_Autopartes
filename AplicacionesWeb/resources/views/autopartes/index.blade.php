<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Autopartes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Lista de Autopartes</h1>
        <table class="table table-striped">
            <thead>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
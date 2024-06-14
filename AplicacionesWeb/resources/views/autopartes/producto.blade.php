<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Autoparte</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Detalles de la Autoparte</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $autopart->autoparte }}</h5>
                <p class="card-text"><strong>Marca:</strong> {{ $autopart->marca }}</p>
                <p class="card-text"><strong>Modelo:</strong> {{ $autopart->modelo }}</p>
                <p class="card-text"><strong>Año del Vehículo:</strong> {{ $autopart->añoVehiculo }}</p>
                <p class="card-text"><strong>Código:</strong> {{ $autopart->codigo }}</p>
                <p class="card-text"><strong>Estado:</strong> {{ $autopart->estado }}</p>
                <p class="card-text"><strong>Precio:</strong> ${{ number_format($autopart->precio, 2) }}</p>
                <p class="card-text"><strong>Color:</strong> {{ $autopart->color }}</p>
                <a href="{{ route('autopartes.index') }}" class="btn btn-primary">Volver a la Lista de Autopartes</a>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

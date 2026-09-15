<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Agregar Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="text-right mr-3">
            <p class="mb-1"><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
            <p class="mb-1"><strong>Rol:</strong> <span
                    class="badge badge-info">{{ Auth::user()->role == 'Empleado' ? 'Empleado' : 'Cliente' }}</span>
            </p>
        </div>
        <h1>Crear Pedido</h1>
        <form action="{{ route('carrito.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="autoparte">Autoparte</label>
                <select name="autoparte" id="autoparte" class="form-control">
                    @foreach ($autoparts as $autopart)
                        <option value="{{ $autopart->autoparte }}">{{ $autopart->autoparte }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>

    <!-- Agregar JS de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Aquí podrías agregar scripts adicionales si los necesitas -->
</body>

</html>
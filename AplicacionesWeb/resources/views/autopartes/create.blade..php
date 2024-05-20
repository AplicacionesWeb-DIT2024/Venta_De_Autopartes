<!DOCTYPE html>
<html>
<head>
    <title>Agregar Autoparte</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Agregar Nueva Autoparte</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('autoparts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="autoparte">Autoparte:</label>
                <input type="text" id="autoparte" name="autoparte" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="añoVehiculo">Año del Vehículo:</label>
                <input type="text" id="añoVehiculo" name="añoVehiculo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</body>
</html>

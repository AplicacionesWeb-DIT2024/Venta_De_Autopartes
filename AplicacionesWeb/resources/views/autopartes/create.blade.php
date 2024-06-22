<!DOCTYPE html>
<html>

<head>
    <title>Agregar Autoparte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 600px;
            /* Limitar el ancho del contenedor */
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Agregar Nueva Autoparte</h1>
        <hr>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="formAgregarAutoparte" action="{{ route('autopartes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="autoparte">Autoparte:</label>
                <input type="text" id="autoparte" name="autoparte" class="form-control" required
                    value="{{ old('autoparte') }}">
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" required value="{{ old('marca') }}">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required value="{{ old('modelo') }}">
            </div>
            <div class="form-group">
                <label for="añoVehiculo">Año del Vehículo:</label>
                <input type="text" id="añoVehiculo" name="añoVehiculo" class="form-control" required
                    value="{{ old('añoVehiculo') }}">
            </div>
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
                    required value="{{ old('codigo') }}">
                @error('codigo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" required value="{{ old('estado') }}">
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" class="form-control" required value="{{ old('precio') }}">
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" class="form-control" required value="{{ old('color') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

</html>
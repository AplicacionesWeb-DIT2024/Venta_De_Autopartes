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

        .invalid-feedback {
            display: block;
            /* Asegura que los mensajes de error se muestren */
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="text-right mr-3">
            <p class="mb-1"><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
            <p class="mb-1"><strong>Rol:</strong> <span
                    class="badge badge-info">{{ Auth::user()->role == 'Empleado' ? 'Empleado' : 'Cliente' }}</span>
            </p>
        </div>
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
                <input type="text" id="autoparte" name="autoparte"
                    class="form-control @error('autoparte') is-invalid @enderror" required
                    value="{{ old('autoparte') }}">
                @error('autoparte')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control @error('marca') is-invalid @enderror"
                    required value="{{ old('marca') }}">
                @error('marca')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                    required value="{{ old('modelo') }}">
                @error('modelo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="añoVehiculo">Año del Vehículo:</label>
                <input type="text" id="añoVehiculo" name="añoVehiculo"
                    class="form-control @error('añoVehiculo') is-invalid @enderror" required
                    value="{{ old('añoVehiculo') }}">
                @error('añoVehiculo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                <select id="estado" name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                    <option value="" disabled selected>Seleccione el estado</option>
                    <option value="Muy bueno" {{ old('estado') == 'Muy bueno' ? 'selected' : '' }}>Muy bueno</option>
                    <option value="Bueno" {{ old('estado') == 'Bueno' ? 'selected' : '' }}>Bueno</option>
                    <option value="Malo" {{ old('estado') == 'Malo' ? 'selected' : '' }}>Malo</option>
                    <option value="Muy malo" {{ old('estado') == 'Muy malo' ? 'selected' : '' }}>Muy malo</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror"
                    required value="{{ old('precio') }}">
                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" class="form-control @error('color') is-invalid @enderror"
                    required value="{{ old('color') }}">
                @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Agregar Autoparte</button>
            <a href="{{ route('autopartes.index') }}" class="btn btn-secondary btn-block mt-2">Volver al Listado de
                Autopartes</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
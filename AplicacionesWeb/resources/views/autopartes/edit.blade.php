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
            max-width: 600px; /* Limitar el ancho del contenedor */
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
        <h1 class="text-center">Editar Autoparte</h1>
        <hr>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('autopartes.update', $autopart->id) }}" method="POST">
        @method ('PUT')    
        @csrf
            <div class="form-group">
                <label for="autoparte">Autoparte:</label>
                <input type="text" id="autoparte" name="autoparte" class="form-control" value = "{{ $autopart->autoparte }}" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value = "{{ $autopart->marca }}" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value= "{{ $autopart->modelo }}" required>
            </div>
            <div class="form-group">
                <label for="añoVehiculo">Año del Vehículo:</label>
                <input type="text" id="añoVehiculo" name="añoVehiculo" class="form-control" value= "{{ $autopart->añoVehiculo }}" required>
            </div>
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" class="form-control" value = "{{ $autopart->codigo }}" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" value = "{{ $autopart->estado }}" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" class="form-control" value = "{{ $autopart->precio }}" required>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" class="form-control" value = "{{ $autopart->color }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Editar</button>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a nuestra tienda de Auto Partes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a nuestra tienda de Auto Partes</h1>
        <p>En nuestra tienda encontrarás una amplia variedad de partes y accesorios para tu vehículo.</p>
        <p>Desde frenos hasta luces, y todo lo que necesitas para mantener tu automóvil en perfecto estado.</p>
        <p>¡Explora nuestro catálogo y encuentra las mejores opciones para tu vehículo!</p>
        <p><a href="{{ route('autopartes.index') }}">Ir al catálogo de productos</a></p>
        <p><a href="{{ route('carrito.index') }}">Ir al carrito</a></p>
    </div>
</body>
</html>
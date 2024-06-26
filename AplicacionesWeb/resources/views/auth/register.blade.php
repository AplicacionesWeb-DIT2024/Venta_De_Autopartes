<!DOCTYPE html>
<html>

<head>
    <title>Registro de Empleados</title>
</head>

<body>
    <h1>Registro de Empleados</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Registrar</button>
    </form>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Confirmar Compra</h1>
        <p>¿Estás seguro que deseas hacer la compra?</p>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carritoItems as $item)
                        <tr>
                            <td>{{ $item->autoparte->autoparte }}</td>
                            <td>{{ $item->autoparte->marca }}</td>
                            <td>{{ $item->autoparte->modelo }}</td>
                            <td>{{ $item->autoparte->precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mb-4">
            <h4>Subtotal: ${{ number_format($carritoItems->sum('autopart.precio'), 2) }}</h4>
        </div>
        <div class="mb-4">
            <h5>Formas de Pago</h5>
            <form action="{{ route('comprar') }}" method="POST">
                @csrf
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forma_pago" id="creditoDebito"
                        value="Credito/Debito" checked>
                    <label class="form-check-label" for="creditoDebito">
                        Crédito/Débito
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forma_pago" id="mercadoPago" value="MercadoPago">
                    <label class="form-check-label" for="mercadoPago">
                        MercadoPago
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="forma_pago" id="efectivo" value="Efectivo">
                    <label class="form-check-label" for="efectivo">
                        Efectivo
                    </label>
                </div>
                <button type="submit" class="btn btn-success mt-3">Confirmar Compra</button>
            </form>
        </div>
        <a href="{{ route('carrito.index') }}" class="btn btn-secondary">Volver al Carrito</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
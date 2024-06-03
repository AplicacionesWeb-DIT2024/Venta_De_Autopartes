<div class="container mt-5">
    <h1>Crear Pedido</h1>
    <!-- Mostrar listado de autopartes -->
    <h2>Listado de Autopartes</h2>
    <ul>
        @foreach ($autoparts as $autopart)
            <li>{{ $autopart->autoparte }}</li>
        @endforeach
    </ul>

    <!-- Mostrar listado de pedidos -->
    @if ($pedidos->isNotEmpty())
        <h2>Listado de Pedidos</h2>
        <ul>
            @foreach ($pedidos as $pedido)
                <li>{{ $pedido->autoparte }} - {{ $pedido->cantidad }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay pedidos aún.</p>
    @endif

    <!-- Formulario para crear nuevo pedido -->
    <form action="{{ route('carrito.store') }}" method="POST">
        @csrf
        <!-- Resto del formulario aquí -->
    </form>
</div>
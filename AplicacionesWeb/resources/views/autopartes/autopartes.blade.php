<!DOCTYPE html>
<html lang="es">

</html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Autopartes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Autopartes</h1>
            @auth
                <div class="d-flex align-items-center">
                    <a href="{{ route('logout') }}" class="btn btn-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Desloguearse
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endauth
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($autoparts->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No hay autopartes disponibles</td>
                        </tr>
                    @else
                        @foreach ($autoparts as $autopart)
                            <tr>
                                <td>{{ $autopart->autoparte }}</td>
                                <td>{{ $autopart->marca }}</td>
                                <td>{{ $autopart->modelo }}</td>
                                <td>{{ number_format($autopart->precio, 2) }}</td>
                                <td>
                                    @if(Auth::check() && Auth::user()->role == 'Empleado')
                                        <a href="{{ route('autopartes.edit', $autopart->id) }}"
                                            class="btn btn-warning btn-sm">Editar</a>
                                    @endif
                                    @if(Auth::check() && Auth::user()->role == 'Empleado')
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                            data-id="{{ $autopart->id }}">Eliminar</button>
                                    @endif
                                    @if(Auth::check() && Auth::user()->role != 'Empleado')
                                        <form action="{{ route('carrito.store') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="autopart_id" value="{{ $autopart->id }}">
                                            <button type="submit" class="btn btn-success btn-sm">Agregar al Carrito</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('autopartes.show', $autopart->id) }}" class="btn btn-info btn-sm">Ver
                                        Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if(Auth::check() && Auth::user()->role == 'Empleado')
            <a href="{{ route('autopartes.create') }}" class="btn btn-primary">Agregar Nueva Autoparte</a>
        @endif

        @if(Auth::check() && Auth::user()->role != 'Empleado')
            <a href="{{ route('carrito.index') }}" class="btn btn-primary">Ir al carrito</a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Ir al Listado de Pedidos</a>
        @endif
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que desea eliminar esta autoparte?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar JS de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Aquí podrías agregar scripts adicionales si los necesitas -->
    <script>
        // Script para manejar el modal de confirmación de eliminación
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var action = '{{ route('autopartes.destroy', ':id') }}'.replace(':id', id);
            var form = $('#deleteForm');
            form.attr('action', action);
        });
    </script>
</body>

</html>
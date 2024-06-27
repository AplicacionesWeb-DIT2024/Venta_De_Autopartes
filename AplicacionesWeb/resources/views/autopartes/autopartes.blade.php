<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Autopartes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Autopartes</h1>
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
                    @foreach ($autoparts as $autopart)
                        <tr>
                            <td>{{ $autopart->autoparte }}</td>
                            <td>{{ $autopart->marca }}</td>
                            <td>{{ $autopart->modelo }}</td>
                            <td>{{ $autopart->precio }}</td>
                            <td>
                                <a href="{{ route('autopartes.edit', $autopart->id) }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                @if(Auth::check() && Auth::user()->hasRole('Empleado'))
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $autopart->id }}">Eliminar</button>
                                @endif
                                <form action="{{ route('carrito.store') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="autopart_id" value="{{ $autopart->id }}">
                                    <button type="submit" class="btn btn-success btn-sm">Agregar al Carrito</button>
                                </form>
                                <a href="{{ route('autopartes.show', $autopart->id) }}" class="btn btn-info btn-sm">Ver
                                    Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(Auth::check() && Auth::user()->hasRole('Empleado'))
            <a href="{{ route('autopartes.create') }}" class="btn btn-primary">Agregar Nueva Autoparte</a>
        @endif

        <a href="{{ route('carrito.index') }}" class="btn btn-primary">Ir al carrito</a>
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
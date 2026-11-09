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

        <form id="formAgregarAutoparte" action="{{ route('autopartes.store') }}" method="POST"
            enctype="multipart/form-data">
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
                <label for="anioVehiculo">Año del Vehículo:</label>
                <input type="text" id="anioVehiculo" name="anioVehiculo"
                    class="form-control @error('anioVehiculo') is-invalid @enderror" required
                    value="{{ old('anioVehiculo') }}">
                @error('anioVehiculo')
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
                    required value="{{ old('precio') }}" inputmode="numeric" placeholder="Ej: 100.000">
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

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror"
                    required value="{{ old('stock', 1) }}" min="1">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label"> Fotos de la autoparte (hasta 5)</label>
                <input type="file" id="fotoPicker" class="form-control" multiple accept="image/*"> {{-- Este input es
                solo para mostrar el selector de archivos, el input real está oculto --}}
                <input type="file" name="foto[]" id="foto" multiple accept="image/*" required style="display: none;">
                {{-- Este input es el que realmente se envía al backend --}}
                <small class="text-muted">Selecciona hasta 5 imágenes de la autoparte.</small>
                <div id="fotoLista" class="mt-2 small"></div>
                @error('foto')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
                @error('foto.*')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" id="btnAgregar" class="btn btn-primary btn-block">
                Agregar Autoparte
            </button>

            <a href="{{ route('autopartes.index') }}" id="btnVolver" class="btn btn-secondary btn-block mt-2">Volver
                al
                Listado de
                Autopartes</a>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const precioInput = document.getElementById('precio');
            const form = document.getElementById('formAgregarAutoparte');

            // acumular fotos (no sobreescribir al elegir de a una)
            const fotoPicker = document.getElementById('fotoPicker');
            const fotoInput = document.getElementById('foto'); // oculto, se envía
            const fotoLista = document.getElementById('fotoLista');
            let fotosAcumuladas = new DataTransfer(); // Para acumular fotos seleccionadas

            function syncFotos() {
                if (fotoInput) {
                    fotoInput.files = fotosAcumuladas.files; // Sincronizar con el input oculto
                }

                if (!fotoLista) return;

                if (fotosAcumuladas.files.length === 0) {
                    fotoLista.innerHTML = '<span class="text-muted">Ninguna imagen seleccionada.</span>';
                    return;
                }

                let html = '<ul class="mb-0 pl-3">';
                Array.from(fotosAcumuladas.files).forEach((f, i) => {
                    html += `<li>${f.name} <button type="button" class="btn btn-link btn-sm text-danger p-0" data-remove-foto="${i}">quitar</button></li>`;
                });
                html += '</ul>';
                fotoLista.innerHTML = html;

                fotoLista.querySelectorAll('[data-remove-foto]').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const idx = parseInt(this.getAttribute('data-remove-foto'), 10);
                        const dt = new DataTransfer();

                        Array.from(fotosAcumuladas.files).forEach((f, i) => {
                            if (i !== idx) {
                                dt.items.add(f);
                            }
                        });

                        fotosAcumuladas = dt;
                        syncFotos();
                    });
                });

            }

            syncFotos();

            if (fotoPicker) {
                fotoPicker.addEventListener('change', function () {
                    const nuevos = Array.from(fotoPicker.files || []);
                    for (const f of nuevos) {
                        if (fotosAcumuladas.files.length >= 5) {
                            alert('Podés subir como máximo 5 imágenes en total.');
                            break;
                        }
                        fotosAcumuladas.items.add(f);
                    }
                    fotoPicker.value = ''; // Permite volver a elegir el mismo archivo
                    syncFotos();
                });
            }

            if (precioInput) {
                function formatearPrecio() {
                    let valor = precioInput.value.replace(/\D/g, '');
                    if (valor === '') {
                        precioInput.value = '';
                        return;
                    }
                    // Agregar puntos cada 3 dígitos desde el final
                    precioInput.value = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                //Formatear al escribir y al salir del campo
                precioInput.addEventListener('input', formatearPrecio);
                precioInput.addEventListener('blur', formatearPrecio);

                formatearPrecio(); //Formatear valor inicial (por si viene con old() o desde edición)

                // Al enviar el formulario, quitar los puntos para que llegue solo el número
                if (form) {
                    form.addEventListener('submit', function (e) {
                        // Validación rápida: máximo 5 imágenes
                        const fotoInput = document.getElementById('foto');
                        if (fotoInput && fotoInput.files && fotoInput.files.length > 5) {
                            e.preventDefault(); // Evitar el envío del formulario
                            alert('Podés subir como máximo 5 imágenes.');
                            return; // Detener el envío del formulario
                        }

                        if (precioInput) {
                            precioInput.value = precioInput.value.replace(/\./g, ''); // Quitar puntos antes de enviar al backend
                        }

                        const btn = document.getElementById('btnAgregar');
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando...`;
                        }

                        const btnVolver = document.getElementById('btnVolver');
                        if (btnVolver) {
                            btnVolver.classList.add('disabled');
                            btnVolver.style.pointerEvents = 'none';
                            btnVolver.setAttribute('aria-disabled', 'true');
                        }
                    });
                }
            }
        })
    </script>

</body>

</html>
import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import "./Crear.css";
import api from "../api"
import Swal from 'sweetalert2'

const Crear = () => {
    const [formData, setFormData] = useState({
        nombre: "",
        marca: "",
        modelo: "",
        anio: "",
        codigo: "",
        estado: "",
        precio: "",
        color: "",
        stock: "",
    });

    const [loading, setLoading] = useState(false);
    const [error, setErrors] = useState({});
    const [fotos, setFotos] = useState([]);
    const [previewFotos, setPreviewFotos] = useState([]);

    const navigate = useNavigate();

    const formatMiles = (valor) => {
        if (!valor) return "";

        const numero = valor
            .toString()
            .replace(/\D/g, "");

        return numero.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Manejo de campos normales
    const handleChange = (e) => {
        const { name, value } = e.target;

        if (error[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ""
            }));
        }

        if (name === "stock") {
            if (value === "") {
                setErrors(prev => ({
                    ...prev,
                    stock: ""
                }));

                setFormData(prev => ({
                    ...prev,
                    stock: ""
                }));
                return;
            }

            if (!/^\d+$/.test(value)) {
                setErrors(prev => ({
                    ...prev,
                    stock: "El stock debe ser un número entero positivo"
                }));
                return;
            }

            setErrors(prev => ({
                ...prev,
                stock: ""
            }));
        };

        // Actualiza el estado del formulario con los nuevos valores
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));

    };

    // Manejo exclusivo de la foto
    const handleFotoChange = (e) => {
        const archivos = Array.from(e.target.files);

        if (fotos.length + archivos.length > 7) {
            setErrors(prev => ({
                ...prev,
                foto: "Máximo 7 fotos permitidas"
            }));
            return;
        }

        const tiposPermitidos = [
            "image/jpeg", "image/png", "image/jpg", "image/webp"
        ];

        for (const archivo of archivos) {
            if (!tiposPermitidos.includes(archivo.type)) {
                setErrors(prev => ({
                    ...prev,
                    foto: "La imagen debe ser JPG, JPEG, PNG O WEBP."
                }));
                return;
            }
            if (archivo.size > 5 * 1024 * 1024) {
                setErrors(prev => ({
                    ...prev,
                    foto: "La imagen no debe superar los 5 MB."
                }));
                return;
            }
        }

        const nuevasFotos = [...fotos, ...archivos];
        const nuevasPreviews = [...previewFotos, ...archivos.map(a => URL.createObjectURL(a))];

        setFotos(nuevasFotos);
        setPreviewFotos(nuevasPreviews);
        setErrors(prev => ({ ...prev, foto: "" }));
    };

    const removeFoto = (index) => {
        const nuevasFotos = fotos.filter((_, i) => i !== index);
        const nuevasPreviews = previewFotos.filter((_, i) => i !== index);
        URL.revokeObjectURL(previewFotos[index]);
        setFotos(nuevasFotos);
        setPreviewFotos(nuevasPreviews);
    };


    // Función para manejar el envío del formulario
    const handleSubmit = async (e) => {
        e.preventDefault();

        let nuevosErrores = {};

        const nombreCampos = {
            nombre: "Nombre",
            marca: "Marca",
            modelo: "Modelo",
            anio: "Año",
            codigo: "Código",
            estado: "Estado",
            precio: "Precio",
            color: "Color",
            stock: "Stock"
        };

        // Validar campos obligatorios
        Object.entries(formData).forEach(([campo, valor]) => {
            if (valor === "") {
                nuevosErrores[campo] =
                    `El campo ${nombreCampos[campo]} es obligatorio`;
            }
        });

        const precioNum = Number(formData.precio);
        const stockNum = Number(formData.stock);

        // Validar precio
        if (
            formData.precio &&
            (isNaN(precioNum) ||
                precioNum < 1 ||
                precioNum > 5000000)
        ) {
            nuevosErrores.precio =
                "Ingrese un precio entre $1 y $5.000.000";
        }

        // Validar stock
        if (
            formData.stock &&
            (stockNum < 1 || stockNum > 99)
        ) {
            nuevosErrores.stock =
                "Ingrese un stock entre 1 y 99";
        }

        //Validar que la foto sea obligatoria
        if (fotos.length === 0) {
            nuevosErrores.foto = "Debe agregar una foto al menos";
        }

        // Si hay errores, no enviamos el formulario
        if (Object.keys(nuevosErrores).length > 0) {
            setErrors(nuevosErrores);
            return;
        }

        try {
            setLoading(true);

            // api.get('/sanctum/csrf-cookie');

            //Crear FormData para enviar datos + foto
            const datos = new FormData();

            datos.append("autoparte", formData.nombre);
            datos.append("marca", formData.marca);
            datos.append("modelo", formData.modelo);
            datos.append("anioVehiculo", formData.anio);
            datos.append("codigo", formData.codigo);
            datos.append("estado", formData.estado);
            datos.append("precio", Number(formData.precio));
            datos.append("color", formData.color);
            datos.append("stock", formData.stock);
            fotos.forEach(f => datos.append("foto[]", f)); // La foto es obligatoria

            await api.post("/autoparts", datos);

            Swal.fire({
                icon: 'success',
                title: 'Autoparte agregada',
                text: 'La autoparte se agregó correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                navigate("/autoparts");
            });
        } catch (error) {
            console.error("Error al crear la autoparte:", error);

            const errors = error.response?.data?.errors;

            if (errors?.codigo) {
                setErrors(prev => ({
                    ...prev,
                    codigo: "El códgio ya está en uso. Por favor, ingrese un código único."
                }));
            }

            if (errors?.precio) {
                setErrors(prev => ({
                    ...prev,
                    precio: errors.precio[0]
                }));
            }

            if (errors?.foto) {
                setErrors(prev => ({
                    ...prev,
                    foto: errors.foto[0]
                }));
            }

            if (
                !errors?.precio &&
                !errors?.codigo &&
                !errors?.foto
            ) {
                alert(
                    error.response?.data?.message ||
                    "Error al crear la autoparte. Por favor, inténtalo de nuevo."
                );
            }
        } finally {
            setLoading(false);
        }
    };

    const currentYear = new Date().getFullYear();

    const years = [];
    for (let year = currentYear; year >= 1930; year--) {
        years.push(year);
    }


    const handleStockKeyDown = (e) => {
        const invalidKeys = ["e", "E", "+", "-", "."];

        if (invalidKeys.includes(e.key)) {
            e.preventDefault()
        }
    };

    useEffect(() => {
        return () => {
            previewFotos.forEach(url => URL.revokeObjectURL(url));
        };
    }, [previewFotos]);

    return (
        <div className="crear-container">
            <h2>Agregar Nueva Autoparte</h2>

            <form onSubmit={handleSubmit} className="crear-form" noValidate>

                <label>Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    value={formData.nombre}
                    onChange={handleChange}
                    required
                />
                {error.nombre && (
                    <small className="text-danger">
                        {error.nombre}
                    </small>
                )}

                <label>Marca</label>
                <input
                    type="text"
                    name="marca"
                    value={formData.marca}
                    onChange={handleChange}
                    required
                />
                {error.marca && (
                    <small className="text-danger">
                        {error.marca}
                    </small>
                )}

                <label>Modelo</label>
                <input
                    type="text"
                    name="modelo"
                    value={formData.modelo}
                    onChange={handleChange}
                    required
                />
                {error.modelo && (
                    <small className="text-danger">
                        {error.modelo}
                    </small>
                )}

                <label>Año</label>
                <select
                    name="anio"
                    value={formData.anio}
                    onChange={handleChange}
                    required
                >
                    <option value="">Seleccione un año</option>
                    {years.map((year) => (
                        <option key={year} value={year}>
                            {year}
                        </option>
                    ))}
                </select>
                {error.anio && (
                    <small className="text-danger">
                        {error.anio}
                    </small>
                )}

                <label>Código</label>
                <input
                    type="text"
                    name="codigo"
                    value={formData.codigo}
                    onChange={handleChange}
                    required
                />
                {error.codigo && (
                    <small className="text-danger">
                        {error.codigo}
                    </small>
                )}

                <label>Estado</label>
                <select name="estado" value={formData.estado} onChange={handleChange}>
                    <option value="">Seleccione un estado</option>
                    <option value="Muy Bueno">Muy Bueno</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                    <option value="Muy Malo">Muy Malo</option>
                </select>
                {error.estado && (
                    <small className="text-danger">
                        {error.estado}
                    </small>
                )}

                <label>Precio</label>
                <input
                    type="text"
                    name="precio"
                    value={formatMiles(formData.precio)}
                    onChange={(e) => {
                        const limpio = e.target.value.replace(/\D/g, "");
                        handleChange({
                            target: {
                                name: "precio",
                                value: limpio
                            }
                        });

                        if (error.precio) {
                            setErrors(prev => ({
                                ...prev,
                                precio: ""
                            }));
                        }
                    }}
                    onKeyDown={handleStockKeyDown}
                    required
                />
                {error.precio && (
                    <small className='text-danger'>
                        {error.precio}
                    </small>
                )}

                <label>Color</label>
                <input
                    type="text"
                    name="color"
                    value={formData.color}
                    onChange={handleChange}
                    required
                />
                {error.color && (
                    <small className="text-danger">
                        {error.color}
                    </small>
                )}

                <label>Stock</label>
                <input
                    type="text"
                    name="stock"
                    value={formData.stock}
                    onChange={handleChange}
                    required
                />
                {error.stock && (
                    <small className="text-danger">
                        {error.stock}
                    </small>
                )}

                <label>Foto de la autoparte</label>
                <div className="foto-container">
                    {previewFotos.length > 0 && (
                        <div className="fotos-grid">
                            {previewFotos.map((src, index) => (
                                <div key={index} className="foto-preview">
                                    <img src={src} alt={`Foto ${index + 1}`} />
                                    <button
                                        type="button"
                                        className="foto-remove"
                                        onClick={() => removeFoto(index)}
                                    >
                                        x
                                    </button>
                                </div>
                            ))}
                        </div>
                    )}
                    {previewFotos.length === 0 && (
                        <div className="foto-placeholder">
                            <p> Selecciona las fotos de la autoparte (máximo 7)</p>
                        </div>
                    )}

                    < input
                        id="foto"
                        type="file"
                        name="foto"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        multiple
                        onChange={handleFotoChange}
                    />

                    <small className="foto-ayuda">
                        JPG, JPEG, PNG O WEBP. Máximo 5MB.
                    </small>

                </div>
                {error.foto && (
                    <small className="text-danger">
                        {error.foto}
                    </small>
                )}

                <button
                    type="submit"
                    disabled={loading}
                    className="d-flex justify-content-center align-items-center gap-2"
                >
                    {loading ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            Agregando...
                        </>
                    ) : (
                        "Agregar Autoparte"
                    )}
                </button>

                {/*Botón rojo para volver a la lista de autopartes */}
                <button
                    type="button"
                    onClick={() => navigate("/autoparts")}
                    className="volver-button"
                    disabled={loading}
                >
                    Volver
                </button>
            </form>
        </div>
    );
}

export default Crear;

import React, { useState } from 'react';
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

    const navigate = useNavigate();

    const formatMiles = (valor) => {
        if (!valor) return "";

        const numero = valor
            .toString()
            .replace(/\D/g, "");

        return numero.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const handleChange = (e) => {
        const { name, value } = e.target;

        if (error[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ""
            }));
        }

        if (name === "stock" && !/^\d*$/.test(value)) {
            return;
        }

        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
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

        /* Mensajes de Error */
        Object.entries(formData).forEach(([campo, valor]) => {
            if (valor === "") {
                nuevosErrores[campo] =
                    `El campo ${nombreCampos[campo]} es obligatorio`;
            }
        });

        const precioNum = Number(formData.precio);

        if (
            formData.precio &&
            (isNaN(precioNum) ||
                precioNum < 1 ||
                precioNum > 5000000)
        ) {

            nuevosErrores.precio =
                "Ingrese un precio entre $1 y 5.000.000";

        }

        if (Object.keys(nuevosErrores).length > 0) {
            setErrors(nuevosErrores);
            return;

        }

        try {
            setLoading(true);

            await api.get('/sanctum/csrf-cookie');

            await api.post('/api/autoparts', {
                autoparte: formData.nombre,
                marca: formData.marca,
                modelo: formData.modelo,
                anioVehiculo: formData.anio,
                codigo: formData.codigo,
                estado: formData.estado,
                precio: Number(formData.precio),
                color: formData.color,
                stock: formData.stock
            });

            Swal.fire({
                icon: 'success',
                title: 'Autoparte agregada',
                text: 'La autoparte se agregó correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                navigate("/autoparts"); // Redirige a la página de listado de autopartes después de crear una nueva
            });


        } catch (error) {
            console.error("Error al crear la autoparte:", error);

            const errors = error.response?.data?.errors;

            if (errors?.codigo) {
                setErrors(prev => ({
                    ...prev,
                    codigo: "El código ya está en uso. Por favor, ingrese un código único."
                }));
            }

            if (errors?.precio) {
                setErrors(prev => ({
                    ...prev,
                    precio: errors.precio[0]
                }));
            }

            if (!error?.precio && !errors?.codigo) {
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
                    type="number"
                    name="stock"
                    value={formData.stock}
                    onChange={handleChange}
                    onKeyDown={handleStockKeyDown}
                    min="1"
                    max="99"
                    step="1"
                    required
                />
                {error.stock && (
                    <small className="text-danger">
                        {error.stock}
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

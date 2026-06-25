import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import "./Crear.css";
import api from "../api"

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
    const [errorPrecio, setErrorPrecio] = useState(""); // Para manejar el error en caso de precio fuera de rango
    const [errorCodigo, setErrorCodigo] = useState(""); // Para manejar el error en caso de código repetido

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

        if (name === "codigo" && errorCodigo) {
            setErrorCodigo("");
        }

        if (name === "stock") {
            if (!/^\d*$/.test(value)) {
                return;
            }
        }
        // No mostrar error en tiempo real: sólo limpiar error existente
        // si el usuario corrige el precio tras un intento de envío.
        if (name === "precio" && errorPrecio) {
            const num = Number(value);
            if (!isNaN(num) && num >= 1 && num <= 5000000) {
                setErrorPrecio("");
            }
        }
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    // Función para manejar el envío del formulario
    const handleSubmit = async (e) => {
        e.preventDefault();

        const precioNum = Number(formData.precio);
        if (isNaN(precioNum) || precioNum < 1 || precioNum > 5000000) {
            setErrorPrecio("Ingrese un precio entre $1 y $5.000.000");
            return;
        }

        if (errorPrecio) {
            return;
        }

        setErrorPrecio("");

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

            alert("Autoparte creada exitosamente!");
            navigate("/autoparts"); // Redirige a la página de listado de autopartes después de crear una nueva

        } catch (error) {
            console.error("Error al crear la autoparte:", error);

            const errors = error.response?.data?.errors;

            if (errors?.precio) {
                setErrorPrecio(errors.precio[0]);
            }

            if (errors?.codigo) {
                setErrorCodigo("El código ya existe. Ingrese uno diferente.");
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

                <label>Marca</label>
                <input
                    type="text"
                    name="marca"
                    value={formData.marca}
                    onChange={handleChange}
                    required
                />

                <label>Modelo</label>
                <input
                    type="text"
                    name="modelo"
                    value={formData.modelo}
                    onChange={handleChange}
                    required
                />

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

                <label>Código</label>
                <input
                    type="text"
                    name="codigo"
                    value={formData.codigo}
                    onChange={handleChange}
                    required
                />
                {errorCodigo && (
                    <small className="text-danger">
                        {errorCodigo}
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

                <label>Precio</label>
                <input
                    type="text"
                    name="precio"
                    value={formatMiles(formData.precio)}
                    onChange={(e) => {
                        const limpio = e.target.value
                            .replace(/\./g, "")
                            .replace(/\D/g, "");
                        setFormData({
                            ...formData,
                            precio: limpio
                        });
                    }}
                    onKeyDown={handleStockKeyDown}
                    required
                />

                {errorPrecio && (
                    <small className='text-danger'>
                        {errorPrecio}
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
                >
                    Volver
                </button>
            </form>
        </div>
    );
}

export default Crear;

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
    });

    const [loading, setLoading] = useState(false);

    const navigate = useNavigate();

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    // Función para manejar el envío del formulario
    const handleSubmit = async (e) => {
        e.preventDefault();

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
                precio: formData.precio,
                color: formData.color
            });

            alert("Autoparte creada exitosamente!");
            navigate("/autoparts"); // Redirige a la página de listado de autopartes después de crear una nueva

        } catch (error) {
            console.error("Error al crear la autoparte:", error);

            alert(
                error.response?.data?.message ||
                "Error al crear la autoparte. Por favor, inténtalo de nuevo."
            );
        } finally {
            setLoading(false);
        }
    };

    const currentYear = new Date().getFullYear();

    const years = [];
    for (let year = currentYear; year >= 1930; year--) {
        years.push(year);
    }

    return (
        <div className="crear-container">
            <h2>Agregar Nueva Autoparte</h2>

            <form onSubmit={handleSubmit} className="crear-form">

                <label>Nombre</label>
                <input type="text" name="nombre" value={formData.nombre} onChange={handleChange} required />

                <label>Marca</label>
                <input type="text" name="marca" value={formData.marca} onChange={handleChange} required />

                <label>Modelo</label>
                <input type="text" name="modelo" value={formData.modelo} onChange={handleChange} required />

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
                <input type="text" name="codigo" value={formData.codigo} onChange={handleChange} required />

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
                <input type="number" name="precio" value={formData.precio} onChange={handleChange} required />

                <label>Color</label>
                <input type="text" name="color" value={formData.color} onChange={handleChange} required />

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
            </form>
        </div>
    );
}

export default Crear;

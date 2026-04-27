import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import "./Crear.css";



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

        const token = localStorage.getItem("token"); // Obtener el token del almacenamiento local

        try {
            const response = await fetch("http://localhost:8080/api/autoparts", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}` // Para incluir el token en la cabecera de autorización
                },
                body: JSON.stringify({
                    autoparte: formData.nombre,
                    marca: formData.marca,
                    modelo: formData.modelo,
                    añoVehiculo: formData.anio,
                    codigo: formData.codigo,
                    estado: formData.estado,
                    precio: formData.precio,
                    color: formData.color
                })
            });

            if (!response.ok) {
                throw new Error("Error al crear la autoparte. Por favor, inténtalo de nuevo.");
            }

            alert("Autoparte creada exitosamente!");
            navigate("/autoparts"); // Redirige a la página de listado de autopartes después de crear una nueva
        } catch (error) {
            console.error("Error al crear la autoparte:", error);
            alert("Error al crear la autoparte. Por favor, inténtalo de nuevo.");
        }
    };

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
                <input type="number" name="anio" value={formData.anio} onChange={handleChange} required />

                <label>Código</label>
                <input type="text" name="codigo" value={formData.codigo} onChange={handleChange} required />

                <label>Estado</label>
                <select name="estado" value={formData.estado} onChange={handleChange}>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>

                <label>Precio</label>
                <input type="number" name="precio" value={formData.precio} onChange={handleChange} required />

                <label>Color</label>
                <input type="text" name="color" value={formData.color} onChange={handleChange} required />

                <button type="submit">Agregar Autoparte</button>
            </form>
        </div>
    );
}

export default Crear;

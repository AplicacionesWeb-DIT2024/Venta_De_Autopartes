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
        estado: "Bueno",
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
                    nombre: formData.nombre,
                    marca: formData.marca,
                    modelo: formData.modelo,
                    anio: formData.anio,
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
            <h2>Crear Nueva Autoparte</h2>

            <form onSubmit={handleSubmit} className="crear-form">

                <input
                    type="text"
                    name="nombre"
                    placeholder="Nombre"
                    value={formData.nombre}
                    onChange={handleChange}
                />

                <input
                    type="text"
                    name="marca"
                    placeholder="Marca"
                    value={formData.marca}
                    onChange={handleChange}
                />

                <input
                    type="text"
                    name="modelo"
                    placeholder="Modelo"
                    value={formData.modelo}
                    onChange={handleChange}
                />

                <input
                    type="number"
                    name="anio"
                    placeholder="Año"
                    value={formData.anio}
                    onChange={handleChange}
                />

                <input
                    type="text"
                    name="codigo"
                    placeholder="Código de Referencia"
                    value={formData.codigo}
                    onChange={handleChange}
                />

                <select
                    name="estado"
                    value={formData.estado}
                    onChange={handleChange}
                >
                    <option value="Muy Bueno">Muy Bueno</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Malo">Malo</option>
                    <option value="Muy Malo">Muy Malo</option>
                </select>

                <input
                    type="number"
                    name="precio"
                    placeholder="Precio"
                    value={formData.precio}
                    onChange={handleChange}
                />

                <input
                    type="text"
                    name="color"
                    placeholder="Color"
                    value={formData.color}
                    onChange={handleChange}
                />

                <button type="submit">Crear Autoparte</button>
            </form>
        </div>
    );
}

export default Crear;
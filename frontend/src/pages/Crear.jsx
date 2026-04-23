import React, { useState } from 'react';
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

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!formData.nombre || !formData.marca || !formData.modelo || !formData.anio || !formData.codigo || !formData.precio || !formData.color) {
            alert("Por favor, completa todos los campos.");
            return;
        }

        console.log("Autoparte creada:", formData);

        //Resetear el formulario
        setFormData({
            nombre: "",
            marca: "",
            modelo: "",
            anio: "",
            codigo: "",
            estado: "Bueno",
            precio: "",
            color: "",
        });
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
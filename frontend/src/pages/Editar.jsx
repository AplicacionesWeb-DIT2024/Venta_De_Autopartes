import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from "../api";
import './Editar.css'; // Importa el CSS para el formulario


export default function Editar() {

    const { id } = useParams();
    const navigate = useNavigate();

    const [formData, setFormData] = useState({
        nombre: "",
        marca: "",
        modelo: "",
        anio: "",
        codigo: "",
        estado: "",
        precio: "",
        color: "",
        stock: ""
    });

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const cargarAutoparte = async () => {
            try {
                const response = await api.get(`/autopartes/${id}`);

                setFormData({
                    nombre: response.data.nombre || "",
                    marca: response.data.marca || "",
                    modelo: response.data.modelo || "",
                    anio: response.data.anio || "",
                    codigo: response.data.codigo || "",
                    estado: response.data.estado || "",
                    precio: response.data.precio || "",
                    color: response.data.color || "",
                    stock: response.data.stock || ""
                });
            } catch (error) {
                console.error("Error al cargar la autoparte:", error);
            } finally {
                setLoading(false);
            }
        };

        cargarAutoparte();
    }, [id]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            await api.put(`/autopartes/${id}`, formData);
            navigate("/autoparts"); // Redirige a la página principal después de actualizar
        } catch (error) {
            console.error("Error al actualizar la autoparte:", error);
            alert("Hubo un error al actualizar la autoparte. Por favor, inténtalo de nuevo.");
        }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    if (loading) {
        return <div>Cargando...</div>;
    }

    return (
        <div className="editar-container">
            <h2>
                Editar Autoparte
            </h2>

            <form onSubmit={handleSubmit} className="editar-form">

                <input
                    type="text"
                    name="nombre"
                    value={formData.nombre}
                    onChange={handleInputChange}
                    placeholder="Nombre"
                    className="form-control mb-3"
                />

                <input
                    type="text"
                    name="marca"
                    value={formData.marca}
                    onChange={handleInputChange}
                    placeholder="Marca"
                    className="form-control mb-3"
                />

                <input
                    type="text"
                    name="modelo"
                    value={formData.modelo}
                    onChange={handleInputChange}
                    placeholder="Modelo"
                    className="form-control mb-3"
                />

                <input
                    type="number"
                    name="anio"
                    value={formData.anio}
                    onChange={handleInputChange}
                    placeholder="Año"
                    className="form-control mb-3"
                />

                <input
                    type="text"
                    name="codigo"
                    value={formData.codigo}
                    onChange={handleInputChange}
                    placeholder="Código"
                    className="form-control mb-3"
                />

                <input
                    type="text"
                    name="estado"
                    value={formData.estado}
                    onChange={handleInputChange}
                    placeholder="Estado"
                    className="form-control mb-3"
                />

                <input
                    type="number"
                    name="precio"
                    value={formData.precio}
                    onChange={handleInputChange}
                    placeholder="Precio"
                    className="form-control mb-3"
                />

                <input
                    type="text"
                    name="color"
                    value={formData.color}
                    onChange={handleInputChange}
                    placeholder="Color"
                    className="form-control mb-3"
                />

                <input
                    type="number"
                    name="stock"
                    value={formData.stock}
                    onChange={handleInputChange}
                    placeholder="Stock"
                    className="form-control mb-3"
                />

                <button
                    type="submit"
                    className="btn btn-primary w-100">
                    Guardar Cambios
                </button>
            </form>
        </div>
    );
}

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
    const [saving, setSaving] = useState(false);

    useEffect(() => {
        // Cargo las caracteristicas de la autoparte a modificar
        const cargarAutoparte = async () => {
            try {
                const response = await api.get(`/api/autoparts/${id}`);

                console.log(response.data)

                const autoparte = response.data;

                setFormData({
                    nombre: autoparte.autoparte || "",
                    marca: autoparte.marca || "",
                    modelo: autoparte.modelo || "",
                    anio: autoparte.anioVehiculo || "",
                    codigo: autoparte.codigo || "",
                    estado: autoparte.estado || "",
                    precio: autoparte.precio || "",
                    color: autoparte.color || "",
                    stock: autoparte.stock || ""
                });
            } catch (error) {
                console.error("Error al cargar la autoparte:", error);
            } finally {
                setLoading(false);
            }
        };

        cargarAutoparte();
    }, [id]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            setSaving(true);

            await api.put(`/api/autoparts/${id}`, {
                autoparte: formData.nombre,
                marca: formData.marca,
                modelo: formData.modelo,
                anioVehiculo: formData.anio,
                codigo: formData.codigo,
                estado: formData.estado,
                precio: formData.precio,
                color: formData.color,
                stock: formData.stock
            });

            navigate("/autoparts");

        } catch (error) {
            console.error("Error al actualizar la autoparte", error);
            alert("Hubo un error al actualizar la autoparte.")
        } finally {
            setSaving(false);
        }
    }

    if (loading) {
        return <div>Cargando...</div>;
    }

    return (
        <div className="editar-container">
            <h2>
                Editar Autoparte
            </h2>

            <form onSubmit={handleSubmit} className="editar-form">

                <label>Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    value={formData.nombre}
                    onChange={handleInputChange}
                    placeholder="Nombre"
                    className="form-control mb-3"
                />

                <label>Marca</label>
                <input
                    type="text"
                    name="marca"
                    value={formData.marca}
                    onChange={handleInputChange}
                    placeholder="Marca"
                    className="form-control mb-3"
                />

                <label>Modelo</label>
                <input
                    type="text"
                    name="modelo"
                    value={formData.modelo}
                    onChange={handleInputChange}
                    placeholder="Modelo"
                    className="form-control mb-3"
                />

                <label>Año</label>
                <input
                    type="number"
                    name="anio"
                    value={formData.anio}
                    onChange={handleInputChange}
                    placeholder="Año"
                    className="form-control mb-3"
                />

                <label>Código</label>
                <input
                    type="text"
                    name="codigo"
                    value={formData.codigo}
                    onChange={handleInputChange}
                    placeholder="Código"
                    className="form-control mb-3"
                />

                <label>Estado</label>
                <select
                    name="estado"
                    value={formData.estado}
                    onChange={handleInputChange}>
                    <option value="">Seleccione un estado</option>
                    <option value="Muy Bueno">Muy Bueno</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                    <option value="Muy Malo">Muy Malo</option>
                </select>

                <label>Precio</label>
                <input
                    type="number"
                    name="precio"
                    value={formData.precio}
                    onChange={handleInputChange}
                    placeholder="Precio"
                    className="form-control mb-3"
                />

                <label>Color</label>
                <input
                    type="text"
                    name="color"
                    value={formData.color}
                    onChange={handleInputChange}
                    placeholder="Color"
                    className="form-control mb-3"
                />
                <label>Stock</label>
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
                    disabled={saving}
                    className="d-flex justify-content-center align-items-center gap-2"
                >
                    {saving ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            Editando...
                        </>
                    ) : (
                        "Guardar Cambios"
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
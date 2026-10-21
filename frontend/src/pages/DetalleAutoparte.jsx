import api, { STORAGE_URL } from "../api";
import { useParams, useNavigate } from "react-router-dom"; // Importamos useParams para obtener el ID de la autoparte desde la URL
import { useState } from "react";
import { useAutoparte } from "../hooks/useAutoparte"; // Importamos el hook personalizado para obtener las autopartes
import "./DetalleAutoparte.css"; // Importamos el archivo CSS para estilos
import Swal from 'sweetalert2'; // Importamos SweetAlert2 para mostrar alertas bonitas

export default function DetalleAutoparte() {

    const { id } = useParams(); // Obtenemos el ID de la autoparte desde los parámetros de la URL
    const navigate = useNavigate(); // Hook para navegar programáticamente

    const [deleting, setDeleting] = useState(false); // Estado para controlar si se está eliminando la autoparte
    const [loadingCart, setLoadingCart] = useState(false); // Estado para controlar si se está agregando al carrito
    const [loadedFotos, setLoadedFotos] = useState(new Set());
    const { autoparte, loading, error } = useAutoparte(id);

    //usuario logueado
    const user = JSON.parse(localStorage.getItem("user") || "null"); // Obtenemos el usuario logueado desde el localStorage

    const formatPrecio = (precio) => {
        return Number(precio).toLocaleString("es-Ar", {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });
    };

    // Verificamos si el usuario es un empleado
    const esEmpleado = user?.role === "Empleado"; // Verificamos si el usuario es un empleado

    const handleDelete = async () => {

        const confirmar = window.confirm(
            "¿Estás seguro de que deseas eliminar esta autoparte? Esta acción no se puede deshacer."
        )

        if (!confirmar) return;

        try {

            setDeleting(true); // Establecemos el estado de eliminación

            await api.delete(`/autoparts/${autoparte.id}`);

            alert("Autoparte eliminada exitosamente.");

            // Redirigir a la lista de autopartes después de eliminar
            navigate("/autoparts");

        } catch (error) {

            console.error("Error al eliminar la autoparte:", error);

            alert("Ocurrió un error al eliminar la autoparte. Por favor, intenta nuevamente.");
        }
    };

    // Si está cargando
    if (loading) {
        return (
            <div className="d-flex flex-column justify-content-center align-items-center vh-100">
                <div
                    className="spinner-border"
                    style={{ width: "4rem", height: "4rem" }}
                    role="status"
                >
                    <span className="visually-hidden">
                        Cargando...
                    </span>
                </div>

                <p className="mt-3 fs-5">
                    Cargando autoparte...
                </p>
            </div>
        );
    }

    // Si no se encontró la autparte (ID inexistente o error de carga)
    if (error || !autoparte) {
        return (
            <div className="container mt-5 text-center">

                <h2>Autoparte no encontrada</h2>

                <p>
                    No existe una autoparte con el ID solicitado.
                </p>

                <button
                    className="btn btn-primary mt-3"
                    onClick={() => navigate("/autoparts")}
                >
                    Volver a la lista de autopartes
                </button>
            </div>
        );
    }

    return (

        <div className="container mt-5 detalle-container">

            <div className="card detalle-card shadow">

                <div className="card-body">

                    {/* FOTO  */}
                    {autoparte.foto ? (
                        <div className="fotos-grid">
                            {(Array.isArray(autoparte.foto) ? autoparte.foto : [autoparte.foto]).map((f, index) => (
                                <div key={index} className="image-wrapper">
                                    {!loadedFotos.has(index) && (
                                        <div className="text-muted py-3">Cargando imagen...</div>
                                    )}
                                    <img
                                        src={`${STORAGE_URL}/${f}`}
                                        alt={`${autoparte.autoparte} ${index + 1}`}
                                        className="img-fluid rounded mb-2"
                                        style={{ width: '100%', display: loadedFotos.has(index) ? 'block' : 'none' }}
                                        onLoad={() => setLoadedFotos(prev => new Set(prev).add(index))}
                                    />
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-4 text-muted">Sin foto</div>
                    )}

                    {/* Nombre de la autoparte */}
                    <h1 className="detalle-titulo">
                        {autoparte.autoparte}
                    </h1>

                    {/* Precio */}
                    <h2 className="text-success mb-4">
                        ${formatPrecio(autoparte.precio)}
                    </h2>

                    {/* Información */}
                    <div className="detalle-info">
                        <p>
                            <strong> Marca: </strong> {autoparte.marca}
                        </p>
                        <p>
                            <strong> Modelo: </strong> {autoparte.modelo}
                        </p>

                        <p>
                            <strong> Año: </strong> {autoparte.anioVehiculo}
                        </p>

                        <p>
                            <strong> Color: </strong> {autoparte.color}
                        </p>

                        <p>
                            <strong> Código: </strong> {autoparte.codigo}
                        </p>

                        <p>
                            <strong> Estado: </strong> {autoparte.estado}
                        </p>
                        <p>
                            <strong> Stock: </strong> {autoparte.stock}
                        </p>

                    </div>
                    {/* Agregar al carrito */}
                    <div className="card-footer bg-white border-0 text-end boton-carrito">
                        {!esEmpleado && (
                            <button
                                className="btn btn-success mb-3"
                                disabled={loadingCart} // Deshabilitar el botón mientras se está agregando al carrito
                                onClick={async () => {
                                    try {
                                        setLoadingCart(true); // Establecer el estado de carga del carrito
                                        await api.post('/carrito', {
                                            autopart_id: autoparte.id,
                                            stock: 1
                                        });
                                        navigate("/carrito");
                                    } catch (err) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Autoparte ya agregada',
                                            text: err.response?.data?.message || 'Error al agregar al carrito',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    } finally {
                                        setLoadingCart(false); // Restablecer el estado de carga del carrito
                                    }
                                }}
                            >
                                {
                                    loadingCart ? (
                                        <>
                                            <span
                                                className="spinner-border spinner-border-sm me-2"
                                                role="status"
                                                aria-hidden="true"
                                            ></span>

                                            Agregando...
                                        </>
                                    ) : (
                                        "Agregar al Carrito"
                                    )}
                            </button>
                        )}
                    </div>

                    {/* Empleado */}
                    {esEmpleado && (
                        <button
                            className="btn btn-danger mt-4 d-flex align-items-center gap-2"
                            onClick={handleDelete}
                            disabled={deleting}
                        >
                            {deleting ? (
                                <>
                                    <span
                                        className="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>

                                    Eliminando...
                                </>
                            ) : (
                                "Eliminar autoparte"
                            )}
                        </button>
                    )}
                </div>
            </div >

            {/*Botón volver*/}
            < div className="text-end mt-3" >
                <button
                    className="btn btn-secondary"
                    onClick={() => navigate("/autoparts")}
                >
                    Volver a la lista de autopartes
                </button>
            </div >
        </div >
    );
}

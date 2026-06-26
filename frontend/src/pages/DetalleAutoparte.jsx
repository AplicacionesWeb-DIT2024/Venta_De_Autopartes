import { useParams, useNavigate } from "react-router-dom"; // Importamos useParams para obtener el ID de la autoparte desde la URL
import { useState } from "react";
import { useAutopartes } from "../hooks/useAutopartes"; // Importamos el hook personalizado para obtener las autopartes
import "./DetalleAutoparte.css"; // Importamos el archivo CSS para estilos

export default function DetalleAutoparte() {

    const { id } = useParams(); // Obtenemos el ID de la autoparte desde los parámetros de la URL
    const navigate = useNavigate(); // Hook para navegar programáticamente

    const [deleting, setDeleting] = useState(false); // Estado para controlar si se está eliminando la autoparte
    const [loadingCart, setLoadingCart] = useState(false); // Estado para controlar si se está agregando al carrito

    const {
        autopartes,
        loading,
        addToCart,
        deleteAutoparte
    } = useAutopartes(); // Obtenemos las autopartes y la función para agregar al carrito desde el hook personalizado

    // Buscar la autoparte por id
    const autoparte = autopartes?.find(
        (a) => String(a.id) === String(id) // Comparamos como strings para evitar problemas de tipo
    );

    //usuario logueado
    const user = JSON.parse(localStorage.getItem("user") || "null"); // Obtenemos el usuario logueado desde el localStorage

    // Verificamos si el usuario es un empleado
    const esEmpleado = user?.role === "Empleado"; // Verificamos si el usuario es un empleado

    // Debug
    console.log(
        "ID de URL:",
        id,
        "Autopartes:",
        autopartes,
        "Encontrado:",
        autoparte
    );

    const handleDelete = async () => {

        const confirmar = window.confirm(
            "¿Estás seguro de que deseas eliminar esta autoparte? Esta acción no se puede deshacer."
        )

        if (!confirmar) return;

        try {

            setDeleting(true); // Establecemos el estado de eliminación

            await deleteAutoparte(autoparte.id);

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

    // Si no hay autopartes cargadas
    if (!autopartes || autopartes.length === 0) {
        return (
            <div className="container mt-5 text-center">

                <h2>No hay autopartes disponibles</h2>

                <p>
                    No se pudieron cargar las autopartes.
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

                    {/* Nombre de la autoparte */}
                    <h1 className="detalle-titulo">
                        {autoparte.autoparte}
                    </h1>

                    {/* Precio */}
                    <h2 className="text-success mb-4">
                        ${Number(autoparte.precio).toFixed(2)}
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

                                        await addToCart(autoparte.id, 1); // Agregamos 1 unidad al carrito

                                        navigate("/carrito");
                                    } catch (err) {
                                        alert('Error al agregar al carrito: ' + err.message);
                                    } finally {
                                        setLoadingCart(false); // Restablecer el estado de carga del carrito
                                    }
                                }}
                            >
                                {loadingCart ? (
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
                            disabled={loading} // Deshabilitar el botón mientras se está eliminando
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
            </div>

            {/*Botón volver*/}
            <div className="text-end mt-3">
                <button
                    className="btn btn-secondary"
                    onClick={() => navigate("/autoparts")}
                >
                    Volver a la lista de autopartes
                </button>
            </div>
        </div>
    );
}

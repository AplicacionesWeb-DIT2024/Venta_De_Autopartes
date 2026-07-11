import { useAutopartes } from "../hooks/useAutopartes"; // Importamos el hook personalizado para obtener las autopartes
import { Link, useNavigate } from "react-router-dom"; // Importamos Link para la navegación
import "./Autopartes.css"; // Importamos el archivo CSS para estilos
import "../index.css"; // importamos index.css para los estilos globales
import { useState } from "react";
import Swal from 'sweetalert2'

// Componente Skeleton para las tarjetas de carga
function SkeletonCard() {
    return (
        <div className="col-md-3 mb-4">
            <div className="card h-100 shadow-sm" style={{ opacity: 0.7 }}>
                <div className="card-body d-flex flex-column text-center">
                    <div className="skeleton-title" style={{
                        height: '20px',
                        backgroundColor: '#e0e0e0',
                        borderRadius: '4px',
                        marginBottom: '12px',
                        animation: 'pulse 1.5s infinite'
                    }}></div>
                    <div className="skeleton-price" style={{
                        height: '24px',
                        backgroundColor: '#e0e0e0',
                        borderRadius: '4px',
                        marginTop: 'auto',
                        animation: 'pulse 1.5s infinite'
                    }}></div>
                </div>
                <div className="card-footer bg-white border-0 text-center">
                    <div style={{
                        height: '38px',
                        backgroundColor: '#e0e0e0',
                        borderRadius: '4px',
                        animation: 'pulse 1.5s infinite'
                    }}></div>
                </div>
            </div>
        </div>
    );
}

export default function Autopartes() {
    const { autopartes, error, loading, addToCart, deleteAutoparte } = useAutopartes(); // Obtenemos las autopartes y funciones del hook
    const navigate = useNavigate(); // Hook para la navegación

    const lista = autopartes || []; // Aseguramos que autopartes sea un array
    const user = JSON.parse(localStorage.getItem('user') || "null"); // Obtenemos el usuario del localStorage
    const esEmpleado = user?.role === 'Empleado'; // Verificamos si el usuario es un empleado
    const [loadingCartId, setLoadingCartId] = useState(null); // Estado para controlar la carga al agregar al carrito
    const [deletingId, setDeletingId] = useState(null); // Estado para controlar qué autoparte se está eliminando
    const isDeleting = deletingId !== null; // Estado para controlar la eliminación de autopartes
    const formatPrecio = (precio) => {
        return Number(precio).toLocaleString("es-AR", {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    };

    // Con este confirmamos la eliminación de una autoparte de forma estética
    const handleDelete = async (id) => {
        const result = await Swal.fire({
            title: 'Eliminar autoparte?',
            text: 'Está seguro de que desea eliminar la autoparte?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {

                setDeletingId(id); // activamos el spinner del botón específico

                await deleteAutoparte(id);

                Swal.fire({
                    icon: 'success',
                    title: 'Autoparte eliminada',
                    text: 'La autoparte fue eliminada exitosamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.reload();
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar la autoparte selccionada.'
                });
            } finally {
                setDeletingId(null); // quitamos el spinner
            }
        }
    };

    return (
        <div className="container mt-5 general-container">

            {/* USUARIO */}
            {user && (
                <div className="text-start mb-3 user-info">
                    <p className="mb-1">
                        Bienvenido, <strong>{user.name}</strong>
                    </p>
                    <p className="mb-0">
                        <span>Rol: </span>
                        <strong>{user.role}</strong>
                    </p>
                </div>
            )}

            {/* BOTÓN LOGOUT */}
            <div className="d-flex justify-content-end mb-3">
                <button
                    className="btn btn-danger"
                    onClick={() => {
                        localStorage.removeItem('user');
                        navigate('/');
                    }}
                >
                    Cerrar Sesión
                </button>
            </div>

            {/* SKELETON LOADING */}
            {loading && (
                <div className="row">
                    {[...Array(4)].map((_, i) => (
                        <SkeletonCard key={i} />
                    ))}
                </div>
            )}

            {/* LISTADO*/}
            {
                !loading && !error && (
                    <>
                        {lista.length === 0 ? (
                            <div className="text-center mt5">
                                <h4 className="text-muted">
                                    No hay autopartes disponibles.
                                </h4>
                            </div>
                        ) : (
                            <div className="row">
                                {lista.map((autopart) => (
                                    <div key={autopart.id} className="col-md-3 mb-4">

                                        <div
                                            className={`card h-100 shadow-sm card-clickeable ${isDeleting ? "opacity-50" : ""
                                                }`}
                                            onClick={() => {
                                                if (isDeleting) return;
                                                navigate(`/autoparts/${autopart.id}`);
                                            }}
                                        >
                                            <div className="card-body d-flex flex-column text-center">

                                                <h5 className="card-title">
                                                    {autopart.autoparte}
                                                </h5>

                                                {/* Precio */}
                                                <h4 className="text-success mt-auto">
                                                    ${formatPrecio(autopart.precio)}
                                                </h4>
                                            </div>

                                            {/* Botón Agregar al Carrito */}
                                            <div className="card-footer bg-white border-0 text-center">
                                                {!esEmpleado && (
                                                    <button
                                                        className="btn btn-success w-100 mb-2"
                                                        disabled={loadingCartId === autopart.id || isDeleting} // Deshabilitar el botón mientras se está agregando al carrito
                                                        onClick={async (e) => {
                                                            e.stopPropagation(); // Evitar que el clic en el botón dispare la navegación a los detalles
                                                            if (isDeleting) return; // Evitar acción si se está eliminando
                                                            try {
                                                                setLoadingCartId(autopart.id); // Activamos el estado de carga

                                                                await addToCart(autopart.id, 1); // Agregamos al carrito

                                                                navigate('/carrito'); // Navegamos al carrito
                                                            } catch (err) {
                                                                alert('Error al agregar al carrito: ' + err.message);
                                                            } finally {
                                                                setLoadingCartId(null); // Desactivamos el estado de carga
                                                            }
                                                        }}
                                                    >
                                                        {loadingCartId === autopart.id ? (
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

                                            <div className="card-footer bg-white border-0 text-center">
                                                {esEmpleado && (
                                                    <>
                                                        <Link
                                                            to={isDeleting ? "#" : `/autoparts/${autopart.id}/editar`}
                                                            className={`btn btn-warning w-100 mb-2 ${isDeleting ? "disabled" : ""}`}
                                                            onClick={(e) => {
                                                                if (isDeleting) {
                                                                    e.preventDefault();
                                                                    return;
                                                                }
                                                                e.stopPropagation();
                                                            }}
                                                        >
                                                            Editar
                                                        </Link>

                                                        <button
                                                            className="btn btn-danger w-100"
                                                            disabled={isDeleting} // Deshabilitar el botón mientras se está eliminando
                                                            onClick={(e) => {
                                                                e.stopPropagation();
                                                                handleDelete(autopart.id);
                                                            }}
                                                        >
                                                            {deletingId === autopart.id ? (
                                                                <>
                                                                    <span
                                                                        className="spinner-border spinner-border-sm me-2"
                                                                        role="status"
                                                                        aria-hidden="true"
                                                                    ></span>
                                                                    Eliminando...
                                                                </>
                                                            ) : (
                                                                "Eliminar"
                                                            )}
                                                        </button>
                                                    </>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </>
                )
            }

            {/* HEADER */}
            <div className="mb-4 text-center">
                {esEmpleado ? ( // Si es Empleado solo tenemos habilitada la creación de Autopartes
                    <>
                        <div className="d-flex justify-content-start">
                            <button
                                className="btn btn-primary"
                                onClick={() => navigate('/autoparts/crear')}
                            >
                                Agregar Autoparte
                            </button>
                        </div>
                    </>
                ) : ( // Si no es Empleado, mostramos el botón para ver el carrito
                    <button
                        className="btn btn-primary"
                        onClick={() => navigate('/carrito')}
                    >
                        Ver Carrito
                    </button>
                )}
            </div>

            {/* ERROR */}
            {
                error && (
                    <div className="alert alert-danger" role="alert">
                        Error al cargar autopartes: {error.message}
                    </div>
                )
            }

        </div >
    );
}

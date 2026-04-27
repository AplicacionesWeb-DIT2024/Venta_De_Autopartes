import { useAutopartes } from "../hooks/useAutopartes"; // Importamos el hook personalizado para obtener las autopartes
import { Link, useNavigate } from "react-router-dom"; // Importamos Link para la navegación
import "./Autopartes.css"; // Importamos el archivo CSS para estilos

export default function Autopartes() {
    const { autopartes, error, loading, addToCart, deleteAutoparte } = useAutopartes(); // Obtenemos las autopartes y funciones del hook
    const navigate = useNavigate(); // Hook para la navegación

    const lista = autopartes || []; // Aseguramos que autopartes sea un array
    const user = JSON.parse(localStorage.getItem('user') || "null"); // Obtenemos el usuario del localStorage
    const esEmpleado = user?.role === 'Empleado'; // Verificamos si el usuario es un empleado

    const handleDelete = (id) => {
        if (window.confirm("¿Estás seguro de que deseas eliminar esta autoparte?")) {
            deleteAutoparte(id); // Llamamos a la función para eliminar la autoparte
        }
    };

    return (
        <div className="container mt-5 autopartes-container">

            {/* USUARIO */}
            {user && (
                <div className="text-end mb-3">
                    <p className="mb-1">
                        Bienvenido, <strong>{user.name}</strong>
                    </p>
                    <p className="mb-0">
                        <span>Rol:</span>
                        <span className="ms-2 badge bg-info">{user.role}</span>
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
                                    <div key={autopart.id} className="col-md-4 mb-4">

                                        <div className="card h-100 shadow-sm">
                                            <div className="card-body d-flex flex-column text-center">

                                                <h5 className="card-title">
                                                    {autopart.name}
                                                </h5>

                                                {/* Marca como badge */}
                                                <p className="badge bg-light text-dark mb-2">
                                                    {autopart.marca}
                                                </p>

                                                {/* Precio */}
                                                <h4 className="text-success mt-auto">
                                                    ${autopart.price.toFixed(2)}
                                                </h4>
                                            </div>

                                            <div className="card-footer bg-white border-0 text-center">

                                                {!esEmpleado && (
                                                    <button
                                                        className="btn btn-success w-100 mb-2"
                                                        onClick={() => addToCart(autopart)}
                                                    >
                                                        Agregar al Carrito
                                                    </button>
                                                )}

                                                {esEmpleado && (
                                                    <button
                                                        className="btn btn-danger w-100"
                                                        onClick={() => handleDelete(autopart.id)}
                                                    >
                                                        Eliminar
                                                    </button>
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

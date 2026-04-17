import { useAutopartes } from "../hooks/useAutopartes";
import { useNavigate } from "react-router-dom"; // Importa el hook useNavigate

export default function Autopartes() {
    const { autopartes, error, loading, addToCart, deleteAutoparte } = useAutopartes();
    const navigate = useNavigate(); // Inicializa el hook useNavigate

    const lista = autopartes || [];
    const user = JSON.parse(localStorage.getItem('user') || "null"); // Asegura que si no hay usuario, se maneje como null en lugar de lanzar un error

    const esEmpleado = user?.role === 'Empleado';

    const handleDelete = (id) => {
        if (window.confirm('¿Estás seguro de que deseas eliminar esta autoparte?')) {
            deleteAutoparte(id);
        }
    };

    return (
        <div className="container mt-5">
            {/*USUARIO*/}
            {user && (
                <div className="text-end mb-3">
                    <p className="mb-1">
                        <strong>Usuario:</strong> {user.name}
                    </p>
                    <p className="mb-0">
                        <strong>Rol:</strong>
                        <span className="ms-1 badge bg-info">{user.role}</span>
                    </p>
                </div>
            )}

            {/*HEADER*/}
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1>Lista de Autopartes</h1>
                <button
                    className="btn btn-danger"
                    onClick={() => {
                        localStorage.removeItem('user');
                        navigate('/');
                    }}
                >
                    Cerrar sesión
                </button>
            </div>

            {/*BOTONES SEGÚN ROL*/}
            {esEmpleado ? (
                <div className="mb-3">
                    <button
                        className="btn btn-primary me-2"
                        onClick={() => navigate('/autopartes/crear')}
                    >
                        Agregar Autoparte
                    </button>
                    <button
                        className="btn btn-secondary"
                        onClick={() => navigate('/autopartes/editar')}
                    >
                        Editar Autoparte
                    </button>
                </div>
            ) : (
                <div className="mb-3">
                    <button
                        className="btn btn-primary"
                        onClick={() => navigate('/carrito')}
                    >
                        Ver Carrito
                    </button>
                </div>
            )}

            {/* ERROR */}
            {error && (
                <div className="alert alert-danger" role="alert">
                    Error al cargar autopartes
                </div>
            )}

            {/* TABLA DE AUTOPARTES EN CARDS*/}
            {!loading && !error && (
                <>
                    {
                        lista.length === 0 ? (
                            <div className="text-center mt-5">
                                <h4 className="text-muted">
                                    No hay autopartes disponibles
                                </h4>
                            </div>
                        ) : (
                            <div className="row">
                                {lista.map((autopart) => (
                                    <div key={autopart.id} className="col-md-4 mb-4">
                                        <div className="card h-100 shadow-sm border-0">
                                            <div className="card-body d-flex flex-column">
                                                <h5 className="card-title fw-bold">
                                                    {autopart.nombre}
                                                </h5>
                                                <p className="mb-2">
                                                    <strong>Marca:</strong> {autopart.marca}
                                                </p>
                                                <h4 className="text-success fw-bold mt-auto">
                                                    ${autopart.precio.toFixed(2)}
                                                </h4>
                                            </div>

                                            <div className="card-footer b-white border-0 text-center">
                                                {!esEmpleado && (
                                                    <button
                                                        className="btn btn-success w-100 mb-2"
                                                        onClick={() => addToCart(autopart)}
                                                    >
                                                        Agregar al Carrito
                                                    </button>
                                                )}

                                                {esEmpleado && (
                                                    <>
                                                        <button
                                                            className="btn btn-danger w-100 mb-2"
                                                            onClick={() => handleDelete(autopart.id)}
                                                        >
                                                            Eliminar
                                                        </button>
                                                    </>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )
                    }
                </>
            )}
        </div>
    );
}
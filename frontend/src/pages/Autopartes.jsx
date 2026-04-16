import { useAutopartes } from "../hooks/useAutopartes";
import { useNavigate } from "react-router-dom"; // Importa el hook useNavigate

export default function Autopartes() {
    const { autopartes, error, addToCart, deleteAutoparte } = useAutopartes();
    const navigate = useNavigate(); // Inicializa el hook useNavigate

    const lista = autopartes || [];
    const user = JSON.parse(localStorage.getItem('user'));

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
                <div className="text-end text-muted mb-3">
                    <p className="mb-1">
                        <strong>Usuario: </strong> {user.name}
                    </p>
                    <span className="badge bg-info">{user.role}</span>
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
            {esEmpleado && (
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
            )}
            {!esEmpleado && (
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
            

            {/* CARGANDO */}
            {loading && (
                <div className="text-center my-5">
                    <div className="spinner-border text-primary" role="status">
                        <span className="visually-hidden">Cargando...</span>
                    </div>
                    <p className="mt-3">Cargando autopartes...</p>
                </div>
            )}

            {/* ERROR */}
            {error && (
                <div className="alert alert-danger" role="alert">
                    Error al cargar autopartes
                </div>
            )}


            {/* TABLA DE AUTOPARTES */}
            {!loading && !error && (
                <div className="card shadow-sm border-0">
                    <div className="table-responsive">
                        <table className="table table-hover align-middle mb-0">
                            <table className="table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Autoparte</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Precio</th>
                                        <th className="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {lista.length === 0 ? ( // Si no hay autopartes, mostrar un mensaje indicando que no hay disponibles
                                        <tr>
                                            <td colSpan="5" className="text-center">
                                                No hay autopartes disponibles.
                                            </td>
                                        </tr>
                                    ) : (
                                        // Iterar sobre la lista de autopartes y mostrar cada una en una fila de la tabla
                                        lista.map((autopart) => (
                                            <tr key={autopart.id}>
                                                <td className="fw-semibold">{autopart.nombre}</td>
                                                <td>{autopart.marca}</td>
                                                <td>{autopart.modelo}</td>
                                                <td className="text-success fw-bold">
                                                    ${autopart.precio.toFixed(2)}
                                                </td>
                                                <td className="text-center">
                                                    <button
                                                        className="btn btn-sm btn-success"
                                                        onClick={() => addToCart(autopart)}
                                                    >
                                                        Agregar al Carrito
                                                    </button>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>
            )}
        </div>
    );
}   

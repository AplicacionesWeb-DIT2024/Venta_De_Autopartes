import { useAutopartes } from "../hooks/useAutopartes";

export default function Autopartes() {
    const { autopartes, loading, error, addToCart } = useAutopartes();

    const lista = autopartes || [];

    return (
        <div className="container mt-5">

            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2>Lista de Autopartes</h2>
                <button
                    className="btn btn-primary"
                    onClick={() => window.location.href = '/carrito'}
                >
                    Ver Carrito
                </button>
            </div>

            {loading && <p>Cargando autopartes...</p>}
            {error && <p className="text-danger">Error al cargar autopartes</p>}

            <table className="table">
                <thead>
                    <tr>
                        <th>Autoparte</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {lista.length === 0 ? ( // Si no hay autopartes, mostrar un mensaje indicando que no hay disponibles
                        <tr>
                            <td colSpan="5">No hay autopartes disponibles.</td>
                        </tr>
                    ) : (
                        // Iterar sobre la lista de autopartes y mostrar cada una en una fila de la tabla
                        lista.map(autopart => (
                            <tr key={autopart.id}>
                                <td>{autopart.autoparte}</td>
                                <td>{autopart.marca}</td>
                                <td>{autopart.modelo}</td>
                                <td>${autopart.precio}</td>
                                <td>
                                    <button
                                        className="btn btn-success btn-sm"
                                        onClick={() => addToCart(autopart.id)}
                                    >
                                        Agregar al carrito
                                    </button>
                                </td>
                            </tr>
                        ))
                    )}
                </tbody>
            </table>
        </div>
    );
}

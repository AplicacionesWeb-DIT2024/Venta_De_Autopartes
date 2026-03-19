import { useAutopartes } from "../hooks/useAutopartes";

export default function Autopartes() {
  const { autopartes, loading, error, addToCart } = useAutopartes();

  if (loading) return <p>Cargando...</p>;
  if (error) return <p>Error al cargar las autopartes.</p>;

  return (
    <div className="container mt-5">
        <h1>Catálogo de Autopartes</h1>
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
                {autopartes.length === 0 ? (
                    <tr>
                        <td colSpan="5">No hay autopartes disponibles.</td>
                    </tr>
                ) : (
                    autopartes.map(autopart => (
                        <tr key={autopart.id}>
                            <td>{autopart.nombre}</td>
                            <td>{autopart.marca}</td>
                            <td>{autopart.modelo}</td>
                            <td>${autopart.precio}</td>
                            <td>
                            <button
                            className="btn btn-success btn-sm" 
                            onClick={() => addToCart(autopart.id)}>Agregar al carrito</button>
                            </td>
                        </tr>
                    ))
                )}
            </tbody>
            </table>
    </div>
  );
}

import { useAutopartes } from "../hooks/useAutopartes";

export default function Autopartes() {
    const { autopartes, addToCart } = useAutopartes();

    return (
        <div className="container mt-5">
            <h1>Catálogo de Autopartes</h1>
            <table className="table">   
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    {autopartes.length === 0 ? (
                        <tr>
                            <td colSpan="5">No hay autopartes disponibles</td>
                        </tr>
                    ) : (   
                    autopartes.map((a) => (
                        <tr key={a.id}>
                            <td>{a.autoparte}</td>
                            <td>{a.descripcion}</td>
                            <td>${a.precio}</td>
                            <td>
                                <button 
                                className="btn btn-primary" 
                                onClick={() => addToCart(a.id)}
                                >
                                Agregar al Carrito
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
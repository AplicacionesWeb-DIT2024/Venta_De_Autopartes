import { useParams, useNavigate } from "react-router-dom";
import { useDetallePedido } from "../hooks/useDetallePedido"; // importo el hook
import "./DetallePedido.css"; //importo el CSS

export default function DetallePedido() {

    const { id } = useParams();
    const navigate = useNavigate();

    const { pedido, loading, error } = useDetallePedido(id);

    if (loading)
        return <h3 className="container mt-5">Cargando pedido...</h3>;

    if (error)
        return <h3 className="container mt-5">Error al cargar el pedido. </h3>


    return (
        <div className="container mt-5 detalle-pedido">

            <h2>Detalle del Pedido #{pedido.id}</h2>

            {/* Información del pedido */}
            <div className="pedido-info">
                <div>
                    <span className="label">Fecha:</span>
                    <strong>
                        {new Date(pedido.fecha_cierre).toLocaleDateString("es-AR")}
                    </strong>
                </div>

                <div>
                    <span className="label">Forma de pago</span>
                    <strong>{pedido.tipo_pago}</strong>
                </div>
            </div>

            {/* Tabla */}
            <div className="table-responsive">
                <table className="table table-hover align-middle">
                    <thead className="table-dark">
                        <tr>
                            <th>Autoparte</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Código</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        {pedido.detalles.map(detalle => (
                            <tr key={detalle.id}>
                                <td>{detalle.autoparte}</td>
                                <td>{detalle.marca}</td>
                                <td>{detalle.modelo}</td>
                                <td>{detalle.codigo}</td>
                                <td className="text-success fw-bold">
                                    ${Number(detalle.precio).toFixed(2)}
                                </td>
                                <td className="text-center">
                                    {detalle.cantidad}
                                </td>
                                <td className="text-success fw-bold">
                                    ${(detalle.precio * detalle.cantidad).toFixed(2)}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            <div className="pie-pedido">

                <div className="acciones-pedido">
                    <button
                        className="btn btn-primary"
                        onClick={() => navigate("/pedidos")}
                    >
                        Volver a Mis Pedidos
                    </button>

                    <button
                        className="btn btn-primary"
                        onClick={() => navigate("/carrito")}
                    >
                        Ver Carrito
                    </button>

                    <button
                        className="btn btn-primary"
                        onClick={() => navigate("/autoparts")}
                    >
                        Volver a Autopartes
                    </button>
                </div>

                <div className="total-box">
                    <span>Total del Pedido</span>
                    <h3>
                        ${Number(pedido.costo_total).toFixed(2)}
                    </h3>
                </div>
            </div>

        </div>
    );
}
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
        <div className="container detalle-pedido">

            <h2>Detalle del Pedido #{pedido.id}</h2>

            <p>
                <strong>Fecha:</strong>{" "}
                {new Date(pedido.fecha_cierre).toLocaleString()}
            </p>

            <p>

                <strong>Forma de pago:</strong> {pedido.tipo_pago}
            </p>

            <div className="table-responsive">

                <table className="table table-bordered">

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
                                <td>${Number(detalle.precio).toFixed(2)}</td>
                                <td>{detalle.cantidad}</td>
                                <td>
                                    $
                                    {(detalle.precio * detalle.cantidad).toFixed(2)}
                                </td>

                            </tr>

                        ))}

                    </tbody>

                </table>

            </div>

            <div className="text-end">
                <h4>
                    Total: ${Number(pedido.costo_total).toFixed(2)}
                </h4>

            </div>
            <button
                className="btn btn-secondary mt-3"
                onClick={() => navigate("/pedidos")}
            >
                Volver
            </button>

        </div>
    );
}
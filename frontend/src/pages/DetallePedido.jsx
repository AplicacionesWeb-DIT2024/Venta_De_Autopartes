import { useParams, useNavigate } from "react-router-dom";
import { useDetallePedido } from "../hooks/useDetallePedido"; // importo el hook
import "./DetallePedido.css"; //importo el CSS

export default function DetallePedido() {

    const formatNumber = (value) => {
        const n = Math.round(Number(value) || 0);
        return new Intl.NumberFormat("de-DE", { maximumFractionDigits: 0 }).format(n);
    }
    const { id } = useParams();
    const navigate = useNavigate();
    const user = JSON.parse(localStorage.getItem("user") || "null"); // Obtenemos el usuario logueado desde el localStorage

    const { pedido, loading, error } = useDetallePedido(id);

    if (loading)
        return <h3 className="container mt-5">Cargando pedido...</h3>;

    if (error)
        return <h3 className="container mt-5">Error al cargar el pedido. </h3>


    return (
        <div className="container mt-5 detalle-pedido">

            {/* USUARIO Y ROL*/}
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
                        localStorage.removeItem("user");
                        navigate("/");
                    }}
                >
                    Cerrar Sesión
                </button>
            </div>

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
                                    ${formatNumber(detalle.precio)}
                                </td>
                                <td className="text-center">
                                    {detalle.cantidad}
                                </td>
                                <td className="text-success fw-bold">
                                    ${formatNumber(detalle.precio * detalle.cantidad)}
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
                        ${formatNumber(pedido.costo_total)}
                    </h3>
                </div>
            </div>

        </div>
    );
}
import { usePedidos } from "../hooks/usePedidos";
import { useNavigate } from "react-router-dom";

import "./Pedidos.css"
import "../index.css"

export default function Pedidos() {

    const { pedidos, loading, error } = usePedidos();

    const navigate = useNavigate();

    const lista = pedidos || [];

    const user = JSON.parse(localStorage.getItem("user") || "null");

    const formatPrecio = (precio) => {
        return Number(precio).toLocaleString("es-AR", {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });
    };

    const formatFecha = (fecha) => {
        return new Date(fecha).toLocaleDateString("es-AR");
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
                        localStorage.removeItem("user");
                        navigate("/");
                    }}
                >
                    Cerrar Sesión
                </button>
            </div>

            <h2 className="text-center mb-4">
                Mis Pedidos
            </h2>

            { /* LOADING*/}
            {loading && (
                <div className="text-center">
                    <div className="spinner-border text-primary" role="status">
                        <span className="visually-hidden">Cargando...</span>
                    </div>
                </div>

            )}

            {/* TABLA */}
            {!loading && !error && (
                <>
                    {lista.length === 0 ? (
                        <div className="alert alert-info text-center">
                            No has hecho pedidos.
                        </div>
                    ) : (
                        <div className="table-responsive">
                            <table className="table table-scripted table-hover align-middle">
                                <thead className="table-dark">
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th className="text-center">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {lista.map((pedido) => (
                                        <tr key={pedido.id}>
                                            <td>
                                                #{pedido.id}
                                            </td>
                                            <td>
                                                {formatFecha(pedido.created_at)}
                                            </td>
                                            <td className="text-success fw-bold">
                                                ${formatPrecio(pedido.total)}
                                            </td>

                                            <td className="text-center">
                                                <button
                                                    className="btn btn-info btn-sm"
                                                    onClick={() => navigate(`/pedidos/${pedido.id}`)}
                                                >
                                                    Ver Detalle
                                                </button>
                                            </td>

                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </>
            )}

            {/* BOTÓN VOLVER */}
            <div className="text-center mt-4">
                <button
                    className="btn btn-primary"
                    onClick={() => navigate("/autoparts")}
                >
                    Volver a Autopartes
                </button>
            </div>

            {/* ERROR */}
            {error && (
                <div className="alert alert-danger mt-4">
                    Error al cargar los pedidos: {error.message}
                </div>
            )}
        </div>
    );
}

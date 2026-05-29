import { use, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

export default function Carrito() {

    const [items, setItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const navigate = useNavigate();

    const token = localStorage.getItem("token");

    const fetchCarrito = async () => {

        try {

            setLoading(true);

            const response = await fetch("http://localhost:8080/api/carrito", {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (!response.ok) {
                throw new Error("Error al cargar el carrito");
            }

            const data = await response.json();
            setItems(data);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }

        useEffect(() => {
            fetchCarrito();
        }, []);

        const eliminarItem = async (itemId) => {

            try {
                const response = await fetch(`http://localhost:8080/api/carrito/${itemId}`, {
                    method: "DELETE",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error("Error al eliminar el item");
                }
                setItems(items.filter(item => item.id !== itemId));

            } catch (err) {
                setError(err.message);
            }
        };

        const actualizarCantidad = async (id, cantidad) => {

            if (cantidad < 1) return;

            try {
                const response = await fetch(`http://localhost:8080/api/carrito/${id}`, {
                    method: "PUT",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ cantidad }),
                });

                if (!response.ok) {
                    throw new Error("Error al actualizar la cantidad");
                }

                fetchCarrito();

            } catch (err) {
                setError(err.message);
            }
        };

        const vaciarCarrito = async () => {

            if (!windows.confirm("¿Estás seguro de vaciar el carrito?")) return;

            try {
                const response = await fetch("http://localhost:8080/api/carrito/vaciar", {
                    method: "DELETE",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error("Error al vaciar el carrito");
                }

                setItems([]);
            } catch (err) {
                alert(err.message);
            }
        };

        const total = items.reduce((acc, item) => {
            return acc + item.precio * item.cantidad;
        }, 0);

        if (loading) {
            return (
                <div className="container mt-5">
                    <h3> Cargando carrito...</h3>
                </div>
            );
        }

        if (error) {
            return (
                <div className="container mt-5">
                    <h3> {error} </h3>
                </div>
            );
        }

        return (
            <div className="container mt-5">
                <div className="d-flex jusify-content-between align-items-center mb-4">
                    <h2>Mi Carrito</h2>

                    <button
                        className="btn btn-secondary"
                        onClick={() => navigate("/autoparts")}
                    >
                        Volver
                    </button>
                </div>

                {items.length === 0 ? (
                    <div className="alert alert-info">
                        El carrito está vacío.
                    </div>
                ) : (
                    <>
                        <div className="table-responsive">

                            <table className="table table-bordered algin-middle">

                                <thead className="table-dark">
                                    <tr>
                                        <th>Autoparte</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    {items.map(item => (

                                        <tr key={item.id}>

                                            <td>
                                                {item.autopart.autoparte}
                                            </td>

                                            <td>
                                                ${Number(item.autopart.precio).toFixed(2)}
                                            </td>

                                            <td style={{ width: "180px" }}>

                                                <div className="d-flex align-items-center gap-2">

                                                    <button
                                                        className="btn btn-outline-secondary"
                                                        onClick={() =>
                                                            actualizarCantidad(
                                                                item.id,
                                                                item.cantidad - 1
                                                            )
                                                        }
                                                    >
                                                        -
                                                    </button>

                                                    <span>
                                                        {item.cantidad}
                                                    </span>

                                                    <button
                                                        className="btn btn-outline-secondary"
                                                        onClick={() =>
                                                            actualizarCantidad(
                                                                item.id,
                                                                item.cantidad + 1
                                                            )
                                                        }
                                                    >
                                                        +
                                                    </button>

                                                </div>

                                            </td>

                                            <td>
                                                $
                                                {
                                                    Number(
                                                        item.autopart.precio *
                                                        item.cantidad
                                                    ).toFixed(2)}
                                            </td>

                                            <td>

                                                <button
                                                    className="btn btn-danger btn-sm"
                                                    onClick={() => eliminarItem(item.id)}
                                                >
                                                    Eliminar
                                                </button>

                                            </td>

                                        </tr>
                                    ))}

                                </tbody>

                            </table>

                        </div>

                        <div className="d-flex justify-content-between algin-tiems-center mt-4">
                            <button
                                className="btn btn-outline-danger"
                                onClick={vaciarCarrito}
                            >
                                Vaciar carrito
                            </button>

                            <div className="text-end">
                                <h4>
                                    Total: ${total.toFixed(2)}
                                </h4>

                                <button
                                    className="btn btn-success mt-2"
                                >
                                    Finalizar Compra
                                </button>
                            </div>
                        </div>
                    </>
                )}

            </div>
        );
    }
}

import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api";
import "./Carrito.css";

export default function Carrito() {

    const [items, setItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const navigate = useNavigate();

    const token = localStorage.getItem('auth_token');

    console.log("Token en Carrito:", token); // Log para verificar que el token se está obteniendo correctamente

    // Función para cargar el carrito desde la API
    const fetchCarrito = async () => {
        try {

            setLoading(true);

            const response = await api.get("/api/carrito", {
                headers: {
                    Accept: "application/json",
                },
            });

            if (!response) {
                throw new Error("Error al cargar el carrito");
            }

            const data = response.data;

            console.log("Datos del carrito:", data); // Log para verificar la respuesta de la API

            setItems(data);

            console.log("Items del carrito:", data); // Log para verificar que los items se están guardando en el estado
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };

    // Cargar el carrito al montar el componente
    useEffect(() => {
        fetchCarrito();
    }, []);



    const eliminarItem = async (itemId) => {

        try {
            await api.delete(`/api/carrito/${itemId}`, {
                headers: {
                    Accept: "application/json",
                },
            });

            setItems(items.filter(item => item.id !== itemId));

        } catch (err) {
            setError(err.message);
        }
    };

    const actualizarCantidad = async (id, stock) => {

        if (stock < 1) return;

        try {
            await api.put(`/api/carrito/${id}`, { stock }, {
                headers: {
                    Accept: "application/json",
                },
            });

            fetchCarrito();

        } catch (err) {
            setError(err.message);
        }
    };

    const vaciarCarrito = async () => {

        if (!window.confirm("¿Estás seguro de vaciar el carrito?")) return;

        try {
            await api.delete("/api/carrito", {
                headers: {
                    Accept: "application/json",
                },
            });

            setItems([]);
        } catch (err) {
            window.alert(err.message);
        }
    };

    const total = items.reduce((acc, item) => {
        return acc + item.autopart.precio * item.stock;
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
        <div className="container mt-5 carrito-container">
            <div className="d-flex justify-content-between align-items-center mb-4 carrito-header">
                <h2>Mi Carrito</h2>


            </div>

            {items.length === 0 ? (
                <div className="carrito-vacio">
                    <h4>El carrito está vacío.</h4>
                </div>
            ) : (
                <>
                    <div className="table-responsive carrito-table">

                        <table className="table table-bordered align-middle">

                            <thead className="table-dark">
                                <tr>
                                    <th>Autoparte</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
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

                                            <div className="cantidad-control">

                                                <button
                                                    className="btn btn-outline-secondary"
                                                    onClick={() =>
                                                        actualizarCantidad(
                                                            item.id,
                                                            item.stock - 1
                                                        )
                                                    }
                                                >
                                                    -
                                                </button>

                                                <span>
                                                    {item.stock}
                                                </span>

                                                <button
                                                    className="btn btn-outline-secondary"
                                                    onClick={() =>
                                                        actualizarCantidad(
                                                            item.id,
                                                            item.stock + 1
                                                        )
                                                    }
                                                >
                                                    +
                                                </button>

                                            </div>

                                        </td>

                                        <td className="item-total">
                                            $
                                            {
                                                Number(
                                                    item.autopart.precio *
                                                    item.stock
                                                ).toFixed(2)}
                                        </td>

                                        <td>

                                            <button
                                                className="btn btn-danger btn-sm"
                                                onClick={() => eliminarItem(item.id)}
                                            >
                                                Eliminar del Carrito
                                            </button>

                                        </td>

                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="d-flex justify-content-between align-items-center mb-4 carrito-header acciones-carrito">
                        <button
                            className="btn btn-outline-danger btn-vaciar"
                            onClick={vaciarCarrito}
                        >
                            Vaciar carrito
                        </button>
                    </div>

                    <button
                        className="btn btn-outline-dark btn-volver"
                        onClick={() => navigate("/autoparts")}
                    >
                        Volver
                    </button>

                    <div className="text-end">
                        <h4 className="carrito-total">
                            Total: ${total.toFixed(2)}
                        </h4>

                        <button
                            className="btn btn-success mt-2 btn-finalizar"
                        >
                            Finalizar Compra
                        </button>
                    </div>
                </>
            )}

        </div>
    );
}

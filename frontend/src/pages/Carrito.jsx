import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api";
import "./Carrito.css";
import "../index.css"; // importamos index.css para los estilos globales

export default function Carrito() {

    const [items, setItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [deleting, setDeleting] = useState(false);
    const [deletingId, setDeletingId] = useState(null);
    const user = JSON.parse(localStorage.getItem('user') || "null"); // Obtenemos el usuario del localStorage

    const navigate = useNavigate();

    const token = localStorage.getItem('auth_token');

    console.log("Token en Carrito:", token); // Log para verificar que el token se está obteniendo correctamente

    // Función para cargar el carrito desde la API
    const fetchCarrito = async () => {
        try {

            setLoading(true);

            const response = await api.get("/carrito", {
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
            setDeleting(true);
            setDeletingId(itemId);

            await api.delete(`/carrito/${itemId}`, {
                headers: {
                    Accept: "application/json",
                }
            });

            setItems(items.filter(item => item.id !== itemId));

        } catch (err) {
            setError(err.message);
        } finally {
            setDeleting(false);
            setDeletingId(null);
        }
    };

    const actualizarCantidad = async (id, nuevoStock, stockDisponible) => {

        nuevoStock = Number(nuevoStock);
        stockDisponible = Number(stockDisponible);

        if (nuevoStock < 1) return;

        if (nuevoStock > stockDisponible) {
            alert("No hay suficiente stock disponible");
            return;
        }

        // Actualización optimista: actualizar UI inmediatamente
        setItems(prevItems => prevItems.map(it => it.id === id ? { ...it, stock: nuevoStock } : it));

        try {
            await api.put(`/carrito/${id}`, { stock: nuevoStock }, {
                headers: {
                    Accept: "application/json",
                },
            });
        } catch (err) {
            setError(err.message);
            // Si falla, re-sincronizar con el servidor
            fetchCarrito();
        }
    };

    const vaciarCarrito = async () => {

        if (!window.confirm("¿Estás seguro de vaciar el carrito?")) return;

        try {
            await api.delete("/carrito", {
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
        <div className="container mt-5 general-container">

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

            <div className="d-flex justify-content-between align-items-center mb-4 carrito-header">
                <h2>Mi Carrito</h2>
            </div>

            {/* BOTÓN LOGOUT */}
            <div className="d-flex justify-content-end mb-3">
                <button
                    className="btn btn-danger"
                    disabled={deleting} // Deshabilitar el botón "Cerrar Sesión" si se está eliminando un item
                    onClick={() => {
                        localStorage.removeItem("user");
                        navigate("/");
                    }}
                >
                    Cerrar Sesión
                </button>
            </div>

            {items.length === 0 ? (
                <div className="carrito-vacio">
                    <h4>El carrito está vacío.</h4>

                    <button
                        className="btn btn-outline-dark mt-3"
                        onClick={() => navigate("/autoparts")}
                    >
                        Ver Autopartes
                    </button>
                    <div>
                        <button
                            className="btn btn-outline-dark btn-pedidos"
                            disabled={deleting}
                            onClick={() => navigate("/pedidos")}
                        >
                            Ver Pedidos
                        </button>
                    </div>
                </div>
            ) : (
                <>
                    <div className="table-responsive carrito-table">

                        <table className="table table-bordered align-middle">

                            <thead className="table-dark">
                                <tr>
                                    <th>Autoparte</th>
                                    <th>Precio</th>
                                    <th>Cantidad a pedir</th>
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
                                            ${Number(item.autopart.precio).toLocaleString("es-AR", {})}
                                        </td>

                                        <td style={{ width: "180px" }}>

                                            <div className="cantidad-control">

                                                <button
                                                    className="btn btn-cantidad"
                                                    disabled={deleting} // Deshabilitar si se está eliminando un item
                                                    onClick={() =>
                                                        actualizarCantidad(
                                                            item.id,
                                                            item.stock - 1,
                                                            item.autopart.stock
                                                        )
                                                    }
                                                >
                                                    -
                                                </button>

                                                <span>
                                                    {item.stock}
                                                </span>

                                                <button
                                                    className="btn btn-cantidad"
                                                    disabled={deleting || item.stock >= item.autopart.stock} // Deshabilitar si se alcanza el stock máximo
                                                    onClick={() =>
                                                        actualizarCantidad(
                                                            item.id,
                                                            item.stock + 1,
                                                            item.autopart.stock
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
                                                Number(item.autopart.precio * item.stock).toLocaleString("es-AR", {})
                                            }
                                        </td>

                                        <td>

                                            <button
                                                className="btn btn-danger btn-sm"
                                                disabled={deleting}
                                                onClick={() => eliminarItem(item.id)}
                                            >
                                                {deleting && deletingId === item.id ? (
                                                    <>
                                                        <span
                                                            className="spinner-border spinner-border-sm me-2"
                                                            role="status"
                                                            aria-hidden="true"
                                                        ></span>
                                                        Eliminando...
                                                    </>
                                                ) : (
                                                    "Eliminar del Carrito"
                                                )}
                                            </button>

                                        </td>

                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="d-flex flex-column align-items-start mb-4 carrito-header acciones-carrito">
                        <button
                            className="btn btn-outline-danger btn-vaciar mb-3"
                            disabled={deleting}
                            onClick={vaciarCarrito}
                        >
                            Vaciar carrito
                        </button>

                        <button
                            className="btn btn-outline-dark btn-volver"
                            disabled={deleting}
                            onClick={() => navigate("/autoparts")}
                        >
                            Agregar otra autoparte
                        </button>
                    </div>

                    <div className="text-end">
                        <h4 className="carrito-total">
                            Total: $
                            {total.toLocaleString("es-AR", {})}
                        </h4>

                        <div className="d-flex justify-content-end gap-2 mt-2">
                            <button
                                className="btn btn-primary"
                                disabled={deleting}
                                onClick={() => navigate("/pedidos")}
                            >
                                Ver Pedidos
                            </button>

                            <button
                                className="btn btn-success btn-finalizar"
                                disabled={deleting}
                                onClick={() => navigate("/confirmar-compra")}
                            >
                                Proceder al pago
                            </button>
                        </div>
                    </div>
                </>
            )}

        </div>
    );
}

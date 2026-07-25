import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api";
import "./ConfirmarCompra.css";

export default function ConfirmarCompra() {

    const [items, setItems] = useState([]);
    const [formaPago, setFormaPago] = useState("Credito/Debito");
    const [loading, setLoading] = useState(true);

    const navigate = useNavigate();

    useEffect(() => {
        cargarCarrito();
    }, []);

    const cargarCarrito = async () => {
        try {
            const respone = await api.get("/api/carrito");
            setItems(respone.data);
        } catch (err) {
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    const total = items.reduce((acc, item) => {
        return acc + (item.autopart.precio * item.stock);
    }, 0);

    const procesarCompra = async () => {

        try {
            console.log(items);
            console.log(total);
            await api.post("/api/comprar", { /*Tengo que poner la ruta que tiene el POST en el backend (api/comprar)*/
                forma_pago: formaPago,
            });

            alert("Compra realizada con éxito");

            navigate("/pedidos");

        } catch (err) {
            console.error(err);

            console.log(err.respone?.data);

            alert(
                err.response?.data?.message ||
                JSON.stringify(err.response?.data) ||
                "Error al realizar la compra"
            );
        }
    };

    if (loading) {
        return <h3 className="container mt-5">Cargando...</h3>;
    }

    return (

        <div className="container confirmar-container">

            <h2>Confirmar Compra</h2>

            <p>Estás seguro que deseas realizar la compra?</p>

            <div className="table-responsive confirmar-table">

                <table className="table table-bordered">

                    <thead className="table-dark">

                        <tr>
                            <th>Autoparte</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>

                    </thead>

                    <tbody>

                        {items.map((item) => (

                            <tr key={item.id}>
                                <td>{item.autopart.autoparte}</td>
                                <td>{item.autopart.marca}</td>
                                <td>{item.autopart.modelo}</td>
                                <td>${Number(item.autopart.precio).toFixed(2)}</td>
                                <td>{item.stock}</td>
                                <td>${(item.autopart.precio * item.stock).toFixed(2)}</td>
                            </tr>

                        ))}

                    </tbody>

                </table>

            </div>

            <div className="text-end mb-4 confirmar-total">

                <h4>
                    Total: ${total.toFixed(2)}
                </h4>

            </div>

            <div className="forma-pago">

                <h5>Forma de Pago</h5>

                <div className="form-check">

                    <input
                        className="form-check-input"
                        type="radio"
                        checked={formaPago === "Credito/Debito"}
                        onChange={() => setFormaPago("Credito/Debito")}
                    />

                    <label className="form-check-label">
                        Crédito/Débito
                    </label>

                </div>

                <div className="form-check">

                    <input
                        className="form-check-input"
                        type="radio"
                        checked={formaPago === "Efectivo"}
                        onChange={() => setFormaPago("Efectivo")}
                    />

                    <label className="form-check-label">
                        Efectivo
                    </label>

                </div>

                <div className="form-check">

                    <input
                        className="form-check-input"
                        type="radio"
                        checked={formaPago === "MercadoPago"}
                        onChange={() => setFormaPago("MercadoPago")}
                    />

                    <label className="form-check-label">
                        MercadoPago
                    </label>


                </div>

            </div>
            <div className="confirmar-botones">

                <button
                    className="btn btn-success"
                    onClick={procesarCompra}
                >
                    Confirmar Compra
                </button>

                <button
                    className="btn btn-secondary"
                    onClick={() => navigate("/carrito")}
                >
                    Volver al carrito
                </button>

            </div>
        </div>
    );
};

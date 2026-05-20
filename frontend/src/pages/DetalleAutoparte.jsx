import { useParams, useNavigate } from "react-router-dom"; // Importamos useParams para obtener el ID de la autoparte desde la URL
import { useAutopartes } from "../hooks/useAutopartes"; // Importamos el hook personalizado para obtener las autopartes
import "./DetalleAutoparte.css"; // Importamos el archivo CSS para estilos

export default function DetalleAutoparte() {

    const { id } = useParams(); // Obtenemos el ID de la autoparte desde los parámetros de la URL
    const navigate = useNavigate(); // Hook para navegar programáticamente

    const { autopartes, addToCart } = useAutopartes(); // Obtenemos las autopartes y la función para agregar al carrito desde el hook personalizado

    // Buscar la autoparte por id
    const autoparte = autopartes?.find(
        (a) => a.id === parseInt(id) // Convertimos el ID a número para compararlo con el ID de las autopartes
    );

    //usuario logueado
    const user = JSON.parse(localStorage.getItem("user") || "null"); // Obtenemos el usuario logueado desde el localStorage
    const esEmpleado = user?.role === "Empleado"; // Verificamos si el usuario es un empleado

    // Si no existe
    if (!autoparte) {
        return (
            <div className="container mt-5 text-center">
                <h2>Autoparte no encontrada</h2>
                <p>La autoparte que estás buscando no existe.</p>

                <button
                    className="btn btn-primary mt-3"
                    onClick={() => navigate("/autoparts")}
                >
                    Volver a la lista de autopartes
                </button>
            </div>
        );
    }

    return (
        <div className="container mt-5 detalle-container">

            {/*Botón volver*/}
            <button
                className="btn btn-secondary mb-4"
                onClick={() => navigate("/autoparts")}
            >
                Volver a la lista de autopartes
            </button>

            <div className="card detalle-card shadow">

                <div className="card-body">

                    {/* Nombre de la autoparte */}
                    <h1 className="detalle-titulo">
                        {autoparte.autoparte}
                    </h1>


                    {/* Marca */}
                    <span className="badge bg-dark mb-3">
                        {autoparte.marca}
                    </span>

                    {/* Precio */}
                    <h2 className="text-success mb-4">
                        ${autoparte.precio.toFixed(2)}
                    </h2>

                    {/* Información */}
                    <div className="detalle-info">

                        <p>
                            <strong> Modelo: </strong> {autoparte.modelo}
                        </p>

                        <p>
                            <strong> Año: </strong> {autoparte.año}
                        </p>

                        <p>
                            <strong> Color: </strong> {autoparte.color}
                        </p>

                        <p>
                            <strong> Estado: </strong> {autoparte.estado}
                        </p>

                        <p>
                            <strong> Descripción: </strong>
                        </p>

                        <div className="descripcion-box">
                            {autoparte.descripcion || "No hay descripción disponible."}
                        </div>
                    </div>

                    {/* Botón agregar al carrito, solo visible para clientes */}
                    {!esEmpleado
                        && (
                            <button
                                className="btn btn-primary mt-4"
                                onClick={() => addToCart(autoparte)}
                            >
                                Agregar al carrito
                            </button>
                        )}

                </div>
            </div>
        </div>
    );
}
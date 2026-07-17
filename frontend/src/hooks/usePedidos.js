import { useEffect, useState } from "react";
import api from "../api";

export const usePedidos = () => {
    const [Pedidos, setPedidos] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        api.get("/api/pedidos")
            .then(res => {
                console.log("Respuesta de pedidos:", res.data);

                setPedidos(res.data);

                setLoading(false);
            })
            .catch(err => {
                console.error("Error al cargar pedidos:", err);

                setError(err);

                setLoading(false);
            });
    }, []);

    return {
        pedidos,
        loading,
        error
    };
};
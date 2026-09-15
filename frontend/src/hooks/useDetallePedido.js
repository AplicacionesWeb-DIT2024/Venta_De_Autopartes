import { useEffect, useState } from "react";
import api from "../api";

export const useDetallePedido = (id) => {

    const [pedido, setPedido] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {

        api.get(`/pedidos/${id}`)
            .then(res => {
                setPedido(res.data);
                setLoading(false);
            })
            .catch(err => {
                console.error(err);
                setError(err);
                setLoading(false);
            });
    }, [id]);

    return {
        pedido,
        loading,
        error
    }
}
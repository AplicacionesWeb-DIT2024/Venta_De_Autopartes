import { useEffect, useState } from "react";
import api from "../api";

const API = import.meta.env.VITE_API_URL;

export const useAutopartes = () => {
  const [autopartes, setAutopartes] = useState([]); // Estado para almacenar las autopartes
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Cargar las autopartes al montar el componente
  useEffect(() => {

    api.get('/api/autoparts?per_page=100')
      .then(res => {

        console.log("Respuesta de autopartes:", res.data);

        // Obtener datos de paginación de Laravel
        const data = res.data.data || res.data || [];

        setAutopartes(data);
        
        setLoading(false);
      })
      .catch(err => {

        console.error('Error al cargar autopartes:', err);

        setError(err);

        setLoading(false);
      }
      )
  }, []);

  const addToCart = async (id) => {
    const token = localStorage.getItem('auth_token');
    await fetch(`${API}/carrito`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        ...(token && { "Authorization": `Bearer ${token}` })
      },
      body: JSON.stringify({ autopart_id: id })
    });
  };

  const deleteAutoparte = async (id) => {
    try {
      await api.delete(`/api/autoparts/${id}`);
      setAutopartes(autopartes.filter(autopart => autopart.id !== id));
      // Invalidar caché cuando se elimina una autoparte
      cache.data = null;
      cache.timestamp = null;
    } catch (err) {
      console.error('Error al eliminar autoparte:', err);
      setError(err);
    }
  };

  return { autopartes, loading, error, addToCart, deleteAutoparte };

};

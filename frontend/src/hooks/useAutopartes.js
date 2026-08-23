import { useEffect, useState } from "react";
import api from "../api";

let cachedAutopartes = null;

export const useAutopartes = () => {
  const [autopartes, setAutopartes] = useState(cachedAutopartes || []);
  const [loading, setLoading] = useState(!cachedAutopartes);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (cachedAutopartes) {
      setLoading(false);
      return;
    }

    api.get('/autoparts?per_page=100')
      .then(res => {
        const data = res.data.data || res.data || [];
        cachedAutopartes = data;
        setAutopartes(data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Error al cargar autopartes:', err);
        setError(err);
        setLoading(false);
      })
  }, []);


  // Función para agregar una autoparte al carrito
  const addToCart = async (id, stock = 1) => {

    try {
      const response = await api.post(`/carrito`, {
        autopart_id: id,
        stock
      });

      console.log("Respuesta carrito:", response.data);

      return response.data;
    } catch (error) {
      console.error('Error al agregar al carrito:', error);
      throw new Error(error.response?.data?.message || 'Error al agregar al carrito');
    }
  };

  const deleteAutoparte = async (id) => {
    try {
      await api.delete(`/autoparts/${id}`);

      setAutopartes(prev =>
        prev.filter(autopart => autopart.id !== id)
      );

    } catch (err) {
      console.error('Error al eliminar autoparte:', err);
      setError(err);
      throw err
    }
  };

  return { autopartes, loading, error, addToCart, deleteAutoparte };

};

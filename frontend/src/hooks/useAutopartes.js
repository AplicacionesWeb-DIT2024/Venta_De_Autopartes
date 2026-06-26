import { useEffect, useState } from "react";
import api from "../api";

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


  // Función para agregar una autoparte al carrito
  const addToCart = async (id, stock = 1) => {

    try {
      const response = await api.post(`/api/carrito`, {
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
      await api.delete(`/api/autoparts/${id}`);
      
      setAutopartes( prev =>
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

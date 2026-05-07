import { useEffect, useState } from "react";
import axios from "axios"; // Importa axios para realizar solicitudes HTTP
import api from "../api";

const API = import.meta.env.VITE_API_URL;

export const useAutopartes = () => {
  const [autopartes, setAutopartes] = useState([]); // Estado para almacenar las autopartes
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Cargar las autopartes al montar el componente
  useEffect(() => {
    
    api.get('/api/autoparts')
      .then(res => {
        setAutopartes(res.data.data || res.data || []); // Maneja diferentes estructuras de respuesta
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
    await fetch(`${API}/carrito`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ autopart_id: id })
    });
  };

  const deleteAutoparte = async (id) => {
    const token = localStorage.getItem('token');
    const config = { headers: { Authorization: `Bearer ${token}` } };

    try {
      await axios.delete(`http://localhost:8000/api/autoparts/${id}`, config);
      setAutopartes(autopartes.filter(autopart => autopart.id !== id));
    } catch (err) {
      console.error('Error al eliminar autoparte:', err);
      setError(err);
    }
  };

  return { autopartes, loading, error, addToCart, deleteAutoparte };

};
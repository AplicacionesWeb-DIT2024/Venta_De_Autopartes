import { useEffect, useState } from "react";
import axios from "axios"; // Importa axios para realizar solicitudes HTTP

const API = import.meta.env.VITE_API_URL;

export const useAutopartes = () => {
  const [autopartes, setAutopartes] = useState([]); // Estado para almacenar las autopartes
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Cargar las autopartes al montar el componente
  useEffect(() => {
    axios.get('/api/autoparts')
      .then(res => {
        setAutopartes(res.data.data); // Asumiendo que la respuesta tiene una estructura { data: [...] }
      })
      .catch(err => {
        setError(err);
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

  return { autopartes, loading, error, addToCart };
}
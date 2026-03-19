import { useEffect, useState } from "react";

const API = import.meta.env.VITE_API_URL;

export const useAutopartes = () => {
  const [autopartes, setAutopartes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch(`${API}/autoparts`)
    .then(res => res.json())
    .then(data => {
      setAutopartes(data);
      setLoading(false);
    })
    .catch(err => {
      setError(err);
      setLoading(false);
    });
  }, []);

  const addToCart = async(id) => {
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
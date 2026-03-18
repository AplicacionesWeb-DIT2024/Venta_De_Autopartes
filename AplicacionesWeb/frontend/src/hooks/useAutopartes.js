import { useEffect, useState } from "react";
const API = import.meta.env.VITE_APP_API_URL;

export function useAutopartes() {
  const [autopartes, setAutopartes] = useState([]);
  
  useEffect(() => {
    fetch(`${API}/autoparts`)
    .then(res => res.json())
    .then(data => setAutopartes(data))
    .catch(err => console.error(err));
  }, []);

  const addToCart = async (id) => {
    await fetch(`${API}/carrito`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ autopartId: id }),
    });
};

    return { autopartes, addToCart };
}
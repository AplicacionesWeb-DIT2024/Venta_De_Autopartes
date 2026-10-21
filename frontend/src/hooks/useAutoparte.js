import { useEffect, useState } from "react";
import api from "../api";

export const useAutoparte = (id) => {

  const [autoparte, setAutoparte] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    setLoading(true);
    setError(null);

    api.get(`/autoparts/${id}`)
      .then(res => {
        setAutoparte(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setError(err);
        setAutoparte(null);
        setLoading(false);
      });
  }, [id]);

  return { autoparte, loading, error };
}

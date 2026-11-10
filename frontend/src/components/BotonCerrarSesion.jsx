import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { logout } from "../api";

const BotonCerrarSesion = ({ disabled = false }) => {
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleLogout = async () => {
        if (loading || disabled) return;

        setLoading(true);

        try {
            await logout();
        } catch (error) {
            console.error("Error al cerrar sesión: ", error);
        } finally {
            navigate("/")
        }
    };

    return (
        <button
            type="button"
            className="btn btn-danger"
            disabled={disabled || loading}
            onClick={handleLogout}
        >
            {loading ? (
                <>
                    <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Cerrando...
                </>
            ) : (
                "Cerrar Sesión"
            )}
        </button>
    );
};

export default BotonCerrarSesion;

import axios from "axios";

export const API_URL = import.meta.env.VITE_API_URL || "http://127.0.0.1:8000/api";

const api = axios.create({
    baseURL: API_URL,
    withCredentials: true,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",
    withXSRFToken: true,
});

// Interceptor para agregar el token en cada solicitud
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("auth_token");

        if (token) {
            config.headers = config.headers || {};
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

export const logout = async () => {
    try {
        await api.post('/logout');
    } catch (e) {

    } finally {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
    }
};
export default api;

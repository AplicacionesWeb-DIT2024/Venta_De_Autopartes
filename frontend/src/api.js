import axios from "axios";

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000',
    withCredentials: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
    withXSRFToken: true
});

export default api;

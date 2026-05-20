//Frontend del Login
import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Login.css'; // Archivo para estilos personalizados
import api from "../api"
import Cookies from 'js-cookie';
import { FaEye, FaEyeSlash } from "react-icons/fa";

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();
  const [errorMsg, setErrorMsg] = useState('');
  const [showPassword, setShowPassword] = useState(false);

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrorMsg(''); // Limpiar mensajes de error anteriores

    try {
      await api.get('/sanctum/csrf-cookie');

      const response = await api.post('/api/login', {
        email: username,
        password
      }, {
        headers: {
          'X-XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
        }
      });

      // Guardar el usuario y token en localStorage
      localStorage.setItem(
        'user',
        JSON.stringify({
          name: response.data.user.name,
          email: response.data.user.email,
          role: response.data.user.role
        })
      );
      //localStorage.setItem('token', response.data.token);

      navigate('/autoparts'); // Redirige a la página de autopartes después del login exitoso

    } catch (error) {
      console.error('ERROR LOGIN: ', error);
      console.error('RESPONSE: ', error.response);

      setErrorMsg(
        error.response?.data?.message ||
        error.message ||
        'Error al iniciar sesión'); // Muestra un mensaje de error al usuario
    }
  };

  return (
    <div className="login-container">
      <div className="login-card">


        <h2 className="login-title">Iniciar Sesión</h2>

        {errorMsg && <p className="login-error">{errorMsg}</p>}

        <form onSubmit={handleLogin}>
          <div className="login-input-group">
            <label>Correo Electrónico</label>
            <input
              type="email"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>

          <div className="login-input-group">
            <label>Contraseña</label>
            <div className="password-container">
              <input
                type={showPassword ? "text" : "password"}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />

              <button
                type="button"
                className="show-password-btn"
                onClick={() => setShowPassword(!showPassword)}
              >
                {showPassword
                  ? <FaEye /> // Icono de ojo abierto
                  : <FaEyeSlash /> // Icono de ojo cerrado
                }
              </button>
            </div>
          </div>

          <button type="submit" className="login-button">
            Iniciar Sesión
          </button>
        </form>

        <div className="login-footer">
          <p>
            ¿No tienes una cuenta? <Link to="/register">Regístrate aquí</Link>
          </p>
        </div>
      </div>
    </div>
  );
};

export default Login;

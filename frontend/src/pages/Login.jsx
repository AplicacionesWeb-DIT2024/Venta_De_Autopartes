//Frontend del Login
import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Login.css'; // Archivo para estilos personalizados

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();
  const [errorMsg, setErrorMsg] = useState('');

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrorMsg(''); // Limpiar mensajes de error anteriores

    try {
      const response = await axios.post('http://localhost:8000/api/login', {
        email: username,
        password
      });

      // Guardar el usuario y token en localStorage
      localStorage.setItem('user', JSON.stringify({
        name: response.data.user.name,
        email: response.data.user.email,
        role: response.data.user.role
      }));
      localStorage.setItem('token', response.data.token);

      navigate('/autoparts'); // Redirige a la página de autopartes después del login exitoso

    } catch (error) {
      setErrorMsg(error.response?.data?.message || 'Error al iniciar sesión'); // Muestra un mensaje de error al usuario
    }
  };

  return (
    <div className="login-container">
      <div className="login-card">

        
        <h2 className="login-title">Iniciar Sesión</h2>
        
        {errorMsg && <p className="login-error">{errorMsg}</p>}
        <form onSubmit={handleLogin}>
          <div className="login-input-group">
            <label htmlFor="email">Correo Electrónico</label>
            <input
              type="email"
              id="email"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
              autoFocus
            />
          </div>
          <div className="login-input-group">
            <label htmlFor="password">Contraseña</label>
            <input
              type="password"
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <button type="submit" className="login-button">
            Iniciar Sesión
          </button>
        </form>
        <div className="login-footer">
          <p>
            ¿No tienes una cuenta?{' '}
            <Link to="/register">Regístrate aquí</Link>
          </p>
        </div>
      </div>
    </div>
  );
}
export default Login;

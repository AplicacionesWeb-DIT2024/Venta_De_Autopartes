//Frontend del Login
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    
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
      console.error('Error during login:', error);
      alert(error.response?.data?.message || 'Error al iniciar sesión'); // Muestra un mensaje de error al usuario
    }
  };

  return (
    <div className="login-container">
      <h2>Login</h2>
      <form onSubmit={handleLogin}>
        <div>
          <label>Email:</label>
          <input
            type="text"
            value={username} // 
            onChange={(e) => setUsername(e.target.value)}
            required
          />
        </div>
        <div>
          <label>Password:</label>
          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </div>
        <button type="submit">Login</button>
        <p>
          {/* Agrega un enlace para registrarse si el usuario no tiene una cuenta */}
          No tenés cuenta? <a href="/register">Register here</a>
        </p>
      </form>
    </div>
  );
}
export default Login;

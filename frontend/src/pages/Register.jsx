// Frontend del Register.jsx
import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import api from '../api';
import './Register.css';
import Cookies from 'js-cookie';



const Register = () => {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [role, setRole] = useState('');

  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (password !== confirmPassword) {
      alert('Las contraseñas no coinciden');
      return;
    }

    // Enviar datos al backend para registrar al usuario
    try {
      // CSRF
      await api.get('/sanctum/csrf-cookie');

      await api.post('/register', {
        name: username,
        email,
        password,
        password_confirmation: confirmPassword,
        role
      }, {
        headers: {
          'X-XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
        }
      });

      alert('Registro existoso! Ahora podés iniciar sesión.');
      navigate('/');

    } catch (error) {
      console.error(error)
      alert(error.response?.data?.message || 'Error al registrarse');
    }
  };

  return (
    <div className="register-container">
      <div className="register-card">
        <h2>Crear una cuenta</h2>

        <form onSubmit={handleSubmit}>
          <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} required />
          <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
          <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
          <input type="password" value={confirmPassword} onChange={(e) => setConfirmPassword(e.target.value)} required />

          <select value={role} onChange={(e) => setRole(e.target.value)} required>
            <option value="">Seleccionar rol</option>
            <option value="Cliente">Cliente</option>
            <option value="Empleado">Empleado</option>
          </select>

          <button type="submit" className="register-button"> Registrarse </button>
        </form>

        <p>
          ¿Ya tenés una cuenta? <Link to="/">Iniciar sesión</Link>
        </p>
      </div>
    </div>
  );
};

export default Register;

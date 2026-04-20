// Frontend del Register.jsx
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { Link } from 'react-router-dom';
import './Register.css';

const Register = () => {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [role, setRole] = useState('');

  const navigate = useNavigate();

  const handleSubmit
    = async (e) => {
      e.preventDefault();

      if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
      }
      // Enviar datos al backend para registrar al usuario
      try {
        await axios.post('http://localhost:8000/api/register', {//TODO no encuentra la ruta, revisar
          name: username,
          email,
          password,
          password_confirmation: confirmPassword,
          role
        });
        alert('Registro exitoso! Ahora podés iniciar sesión.');
        navigate('/');
      } catch (error) {
        alert(error.response?.data?.message || 'Error al registrarse');
      }
    };

  return (
    <div className="register-container">
      <div className="register-card">
        <h2 className="register-title">Crear una cuenta</h2>
        <form onSubmit={handleSubmit}>
          <div className="register-input-group">
            <label>Nombre de usuario</label>
            <input
              type="text"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>
          <div className="register-input-group">
            <label>Email</label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          <div className="register-input-group">
            <label>Contraseña</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <div className="register-input-group">
            <label>Confirmar contraseña</label>
            <input
              type="password"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
              required
            />
          </div>
          <div className="register-input-group">
            <label>Rol</label>
            <select value={role} onChange={(e) => setRole(e.target.value)} required>
              <option value="">Seleccionar rol</option>
              <option value="customer">Cliente</option>
              <option value="admin">Administrador</option>
            </select>
          </div>
          <button type="submit" className="register-button">Registrarse</button>
        </form>
        <p className="register-footer">
          ¿Ya tenés una cuenta? <Link to="/">Iniciar sesión</Link>
        </p>
      </div>
    </div>
  );
};
export default Register;

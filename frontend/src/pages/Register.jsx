// Frontend del Register.jsx
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { Link } from 'react-router-dom';

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
        navigate('/login');
      } catch (error) {
        alert(error.response?.data?.message || 'Error al registrarse');
      }
    };

  return (
    <div>
      <h2>Registrarse</h2>

      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
          required
        />

        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />

        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />

        <input type="password"
          placeholder="Confirm Password"  /*Botón para registrarse y redirigir al login*/
          value={confirmPassword}
          onChange={(e) => setConfirmPassword(e.target.value)}
          required />

        <select value={role} onChange={(e) => setRole(e.target.value)} required>
          <option value="">Seleccionar Rol</option>
          <option value="cliente">Cliente</option>
          <option value="empleado">Empleado</option>
        </select>
        {/*Botón para registrarse y redirigir al login*/}
        <button type="submit">Register</button>


        {/* Agrega un enlace para redirigir a la página de inicio de sesión */}
        <p>
          Ya tenés cuenta? <Link to="/login">Login here</Link>
        </p>

      </form>
    </div>
  );
};
export default Register;

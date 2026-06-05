// Frontend del Register.jsx
import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import api from '../api';
import './Register.css';
import Cookies from 'js-cookie';
import { FaEye, FaEyeSlash } from "react-icons/fa";
import Swal from 'sweetalert2';

const Register = () => {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [role, setRole] = useState('');

  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);

  const [loading, setLoading] = useState(false);

  const [errorMsg, setErrorMsg] = useState('');

  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    setErrorMsg('');
    setLoading(true);

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
      setErrorMsg('Las contraseñas no coinciden');
      setLoading(false);
      return;
    }

    // Enviar datos al backend para registrar al usuario
    try {
      // Obtener el token CSRF antes de hacer la solicitud de registro
      await api.get('/sanctum/csrf-cookie');

      // Registrar al usuario
      const response = await api.post('/register', { // Enviamos los datos del formulario al backend
        name: username,
        email,
        password,
        password_confirmation: confirmPassword,
        role
      }, {
        headers: {
          'X-XSRF-TOKEN': decodeURIComponent(
            Cookies.get('XSRF-TOKEN')
          )
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

      // Guardar el token en localStorage
      localStorage.setItem('auth_token', response.data.token);

      Swal.fire({
        icon: 'success',
        title: 'Registro exitoso',
        text: '¡Bienvenido a AutoPartes!',
        confirmButtonText: 'Ir al inicio'
      }).then(() => {
        navigate('/'); //Redireccionar al inicio de sesión después del registro
      });

    } catch (error) {
      console.error(error)

      setErrorMsg(
        error.response?.data?.message ||
        'Error al registrarse'
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="register-container">

      <div className="register-card">

        <h2 className="register-title">
          Crear una cuenta
        </h2>

        {errorMsg && (
          <p className="register-error">
            {errorMsg}
          </p>
        )}

        <form onSubmit={handleSubmit}>

          {/* Nombre de usuario */}
          <div className="register-input-group">
            <label>Nombre de usuario</label>

            <input
              type="text"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>

          {/* Correo electrónico */}
          <div className="register-input-group">
            <label>Correo electrónico</label>

            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>

          {/* Contraseña */}
          <div className="register-input-group">
            <label>Contraseña</label>

            <div className="register-password-container">

              <input
                type={showPassword ? "text" : "password"}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />

              <button
                type="button"
                className="show-password-btn"
                onClick={() =>
                  setShowPassword(!showPassword)
                }
              >
                {showPassword
                  ? <FaEye /> // Icono de ojo cerrado
                  : <FaEyeSlash /> // Icono de ojo abierto
                }
              </button>

            </div>
          </div>

          {/* Confirmar contraseña */}
          <div className="register-input-group">
            <label>Confirmar contraseña</label>

            <div className="register-password-container">

              <input
                type={
                  showConfirmPassword
                    ? "text"
                    : "password"
                }
                value={confirmPassword}
                onChange={(e) =>
                  setConfirmPassword(e.target.value)
                }
                required
              />

              <button
                type="button"
                className="show-password-btn"
                onClick={() =>
                  setShowConfirmPassword(
                    !showConfirmPassword
                  )
                }
              >
                {showConfirmPassword
                  ? <FaEye /> // Icono de ojo cerrado
                  : <FaEyeSlash /> // Icono de ojo abierto
                }
              </button>

            </div>
          </div>

          {/* Selección de rol */}
          <div className="register-input-group">
            <label>Rol</label>

            <select
              className="register-select"
              value={role}
              onChange={(e) => setRole(e.target.value)}
              required
            >
              <option value="">
                Seleccionar rol
              </option>

              <option value="Cliente">
                Cliente
              </option>

              <option value="Empleado">
                Empleado
              </option>
            </select>
          </div>

          {/* Botón de registro */}
          <button
            type="submit"
            className="register-button"
            disabled={loading}
          >
            {loading ? (
              <>
              <span className="spinner"></span>
              Registrando...
              </>
            ) : (
              'Registrarse'
            )}
          </button>
        </form>

        {/* Enlace para iniciar sesión */}
        <div className="register-footer">
          <p>
            ¿Ya tenés una cuenta? {""}
            <Link to="/">
              Iniciar sesión
            </Link>
          </p>
        </div>

      </div >
    </div >
  );
};

export default Register;

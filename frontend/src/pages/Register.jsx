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

  const [errors, setErrors] = useState({});
  const [errorMsg, setErrorMsg] = useState('');

  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    setErrors({});
    setErrorMsg('');
    setLoading(true);

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
      setErrors(prev => ({
        ...prev,
        confirmPassword: 'Las contraseñas no coinciden'
      }));
      setLoading(false);
      return;
    }

    let nuevosErrores = {};

    if (!username.trim()) {
      nuevosErrores.username =
        "El nombre de usuario es obligatorio";
    }

    if (!email.trim()) {
      nuevosErrores.email =
        "El correo electrónico es obligatorio";
    } else if (!/^[A-Za-z0-9]+([._%+-][A-Za-z0-9]+)*@[A-Za-z0-9]+([.-][A-Za-z0-9]+)*\.[A-Za-z]{2,}$/.test(email)) {
      nuevosErrores.email =
        "El correo electrónico no es válido";
    }

    if (!password) {
      nuevosErrores.password =
        "La contraseña es obligatoria";
    } else if (password.length < 8) {
      nuevosErrores.password =
        "La contraseña debe tener al menos 8 caracteres";
    }

    if (!confirmPassword) {
      nuevosErrores.confirmPassword =
        "Debe confirmar la contraseña";
    }
    else if (password !== confirmPassword) {
      nuevosErrores.confirmPassword =
        "Las contraseñas no coinciden";
    }

    if (!role) {
      nuevosErrores.role =
        "Debe seleccionar un rol";
    }

    if (Object.keys(nuevosErrores).length > 0) {
      setErrors(nuevosErrores);
      setLoading(false);
      return;
    }

    // Enviar datos al backend para registrar al usuario
    try {
      // Obtener el token CSRF antes de hacer la solicitud de registro
      await api.get('/sanctum/csrf-cookie');

      // Registrar al usuario
      const response = await api.post('/api/register', { // Enviamos los datos del formulario al backend
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

      const backendErrors = error.response?.data.errors;

      if (backendErrors) {
        setErrors({
          username: backendErrors.name?.[0],
          email: backendErrors.email?.[0],
          password: backendErrors.password?.[0],
          confirmPassword: backendErrors.password_confirmation?.[0],
          role: backendErrors.role?.[0]
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error de registro',
          text: error.response?.data.message || 'Ocurrió un error al registrar el usuario. Por favor, inténtelo de nuevo.',
        });
      }
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ""
      }))
    }

    switch (name) {
      case 'username':
        setUsername(value);
        break;

      case 'email':
        setEmail(value);
        break;

      case 'password':
        setPassword(value);
        break;

      case 'confirmPassword':
        setConfirmPassword(value);
        break;

      case 'role':
        setRole(value);
        break;

      default:
        break;
    }
  };

  return (
    <div className="register-container">

      <div className="register-card">

        <div className="auth-brand">
          <span className="brand-name">Autopartes AR</span>
          <span className="auth-brand-tag">Repuestos de taller</span>
          <div className="hazard-stripes"></div>
        </div>

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
              name="username"
              value={username}
              onChange={handleChange}
            />
            {/* Mostrar mensaje de error si existe */}
            {errors.username && (
              <small className="text-danger">
                {errors.username}
              </small>
            )}
          </div>

          {/* Correo electrónico */}
          <div className="register-input-group">
            <label>Correo electrónico</label>
            <input
              type="email"
              name="email"
              value={email}
              onChange={handleChange}
            />
          </div>
          {errors.email && (
            <small className="text-danger">
              {errors.email}
            </small>
          )}


          {/* Contraseña */}
          <div className="register-input-group">
            <label>Contraseña</label>
            <div className="register-password-container">
              <input
                type={showPassword ? "text" : "password"}
                name="password"
                value={password}
                onChange={handleChange}
              />
              {/*Botón para mostrar/ocultar contraseña*/}
              <button
                type="button"
                className="show-password-btn"
                onClick={() => setShowPassword(!showPassword)}
              >
                {showPassword ? <FaEye /> : <FaEyeSlash />}
              </button>
            </div>
            {/*Mostrar mensaje de error si existe */}
            {errors.password && (
              <small className="text-danger">
                {errors.password}
              </small>
            )}
          </div>


          {/* Confirmar contraseña */}
          <div className="register-input-group">
            <label>Confirmar contraseña</label>

            <div className="register-password-container">
              <input
                type={showConfirmPassword ? "text" : "password"}
                name="confirmPassword"
                value={confirmPassword}
                onChange={handleChange}
              />
              <button /*Botón para mostrar/ocultar contraseña*/
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
            {errors.confirmPassword && (
              <small className="text-danger">
                {errors.confirmPassword}
              </small>
            )}



          </div>

          {/* Selección de rol */}
          <div className="register-input-group">
            <label>Rol</label>

            <select
              name="role"
              className="register-select"
              value={role}
              onChange={handleChange}
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
            {errors.role && (
              <small className="text-danger">
                {errors.role}
              </small>
            )}
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
            <Link
              to={loading ? "#" : "/"} // Si el register está en proceso, deshabilita el link; sino, el link está normal.
              onClick={(e) => {
                if (loading) {
                  e.preventDefault();
                }
              }}
              className={loading ? "disableLogin" : ""} //Aspecto de deshabilitación armado en el css
            >
              Iniciar sesión
            </Link>
          </p>
        </div>

      </div >
    </div >
  );
};

export default Register;

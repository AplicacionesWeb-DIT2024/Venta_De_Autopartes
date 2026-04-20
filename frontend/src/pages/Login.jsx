//Frontend del Login
import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css'; // Importa los estilos de Bootstrap

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
    <div className="container">
      <div className="row justify-content-center" style={{ marginTop: '80px' }}>
        <div className="col-md-6" col-lg-5>

          <div className="card shadow">
            <div className="card-header text-center">
              <h2>Login</h2>
            </div>

            <div className="card-body">
              <form onSubmit={handleLogin}>

                {/* ERROR */}
                {errorMsg && (
                  <div className="alert alert-danger">
                    {errorMsg}
                  </div>
                )}

                {/* EMAIL */}
                <div className="mb-3">
                  <label className="form-label">Email address:</label>
                  <input
                    type="email"
                    className="form-control"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                    required
                    autoFocus
                  />
                </div>

                {/* PASSWORD */}
                <div className="mb-3">
                  <label className="form-label">Password:</label>
                  <input
                    type="password"
                    className="form-control"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>

                {/* BOTONES */}
                <div className="d-flex justify-content-between align-items-center">
                  <button type="submit" className="btn btn-primary">
                    Login
                  </button>

                  <Link to="/register" className="btn btn-link">
                    Registrarse
                  </Link>
                </div>

              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
  );
}
export default Login;

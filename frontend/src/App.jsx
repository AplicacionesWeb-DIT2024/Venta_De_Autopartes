// Código para configurar las rutas de la aplicación utilizando React Router

import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';
import Home from './pages/Home';
import Dashboard from './pages/Dashboard';
import Autopartes from './pages/Autopartes'; // Importa la página de Autopartes
import Crear from './pages/Crear'; // Importa la página de Crear
function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/home" element={<Home />} />
        <Route path="/register" element={<Register />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/autoparts" element={<Autopartes />} /> {/* Ruta para la página de Autopartes */} 
        <Route path="/autoparts/crear" element={<Crear />} /> {/* Ruta para la página de Crear */}
      </Routes>
    </Router>
  );
}

export default App;

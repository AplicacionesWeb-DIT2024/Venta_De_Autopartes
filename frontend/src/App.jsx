// Código para configurar las rutas de la aplicación utilizando React Router

import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';
import Home from './pages/Home';
import Dashboard from './pages/Dashboard';
import Autopartes from './pages/Autopartes'; // Importa la página de Autopartes
import Crear from './pages/Crear'; // Importa la página de Crear
import DetalleAutoparte from './pages/DetalleAutoparte'; // Importa la página de DetalleAutopartes
import Carrito from './pages/Carrito'; // Importa la página de Carrito
import Editar from './pages/Editar'; // Importa la página de Editar
import ConfirmarCompra from './pages/ConfirmarCompra'; // Importa la página de ConfirmarCompra
import Pedidos from './pages/Pedidos';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/home" element={<Home />} />
        <Route path="/register" element={<Register />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/autoparts" element={<Autopartes />} /> {/* Ruta para la página de Autopartes */}
        <Route path="/autoparts/crear" element={<Crear />} /> {/* Ruta para crear - DEBE IR ANTES DEL :id */}
        <Route path="/autoparts/:id" element={<DetalleAutoparte />} /> {/* Ruta para la página de DetalleAutopartes */}
        <Route path="/carrito" element={<Carrito />} /> {/* Ruta para la página del Carrito */}
        <Route path="/pedidos" element={<Pedidos />} />
        <Route path="/autoparts/:id/editar" element={<Editar />} /> {/* Ruta para la página de Editar */}
        <Route path="/confirmar-compra" element={<ConfirmarCompra />} /> {/* Ruta para la página de Confirmar Compra */}
      </Routes>
    </Router>
  );
}

export default App;

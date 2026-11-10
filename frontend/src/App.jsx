// Código para configurar las rutas de la aplicación utilizando React Router

import { BrowserRouter as Router, Routes, Route, Navigate, NavigationType } from 'react-router-dom';
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
import DetallePedido from "./pages/DetallePedido";

// Guard: rutas administrativas solo para Empleado
function RutaEmpleado({ children }) {
  const user = JSON.parse(localStorage.getItem("user") || "null");

  if (!user) {
    return <Navigate to="/" replace />;
  }

  if (user.role !== "Empleado") {
    return <Navigate to="/autoparts" replace />;
  }

  return children;
}

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/home" element={<Home />} />
        <Route path="/register" element={<Register />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/autoparts" element={<Autopartes />} /> {/* Ruta para la página de Autopartes */}
        <Route path="/autoparts/crear" element={<RutaEmpleado><Crear /></RutaEmpleado>} /> {/* Ruta para crear */}
        <Route path="/autoparts/:id" element={<DetalleAutoparte />} /> {/* Ruta para la página de DetalleAutopartes */}
        <Route path="/carrito" element={<Carrito />} /> {/* Ruta para la página del Carrito */}
        <Route path="/pedidos" element={<Pedidos />} />
        <Route path="/autoparts/:id/editar" element={<RutaEmpleado><Editar /></RutaEmpleado>} /> {/* Ruta para la página de Editar */}
        <Route path="/confirmar-compra" element={<ConfirmarCompra />} /> {/* Ruta para la página de Confirmar Compra */}
        <Route path="/pedidos/:id" element={<DetallePedido />} />
      </Routes>
    </Router>
  );
}

export default App;

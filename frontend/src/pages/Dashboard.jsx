// Dashboard.jsx
import { useNavigate } from 'react-router-dom';

const Dashboard = () => {
  const navigate = useNavigate();

  return (
    <div className="home-page">
      <header className="home-hero">
        <span className="brand-name">Autopartes AR</span>
        <h1>Panel</h1>
        <p className="home-sub">
          Tus operaciones de repuestos están en el catálogo.
        </p>
        <button className="btn btn-success" onClick={() => navigate('/autoparts')}>
          Ir al catálogo
        </button>
      </header>
      <div className="hazard-stripes"></div>
    </div>
  );
}

export default Dashboard;

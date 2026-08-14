// Home.jsx
import { useNavigate } from 'react-router-dom';

const Home = () => {
  const navigate = useNavigate();

  return (
    <div className="home-page">
      <header className="home-hero">
        <span className="brand-name">Autopartes AR</span>
        <h1>Repuestos que hacen andar tu taller</h1>
        <p className="home-sub">
          Buscá la pieza por marca, modelo y año. Fotografía del estado real,
          código identificatorio y precio en pesos.
        </p>
        <button className="btn btn-success" onClick={() => navigate('/autoparts')}>
          Ver repuestos
        </button>
      </header>
      <div className="hazard-stripes"></div>
    </div>
  );
}

export default Home;

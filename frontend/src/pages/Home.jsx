// Home.jsx
import React from 'react';
import { Link } from 'react-router-dom';

const Home = () => {
  return (
    <div className="home-container">
      <h1>Welcome to the Home Page</h1>
      <p>This is the main landing page of our application.</p>
      <Link to="/about">Go to About Page</Link>
    </div>
  );
}
export default Home;
import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/Login';

const loginElement = document.getElementById('login');

if (loginElement) {
    createRoot(loginElement).render(<Login />);
}
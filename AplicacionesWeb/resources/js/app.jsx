import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/Login';
import Register from './components/Register';

if (document.getElementById('login')) {
    createRoot(document.getElementById('login')).render(<Login />);
}

if (document.getElementById('register')) {
    createRoot(document.getElementById('register')).render(<Register />);
}
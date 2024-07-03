import './bootstrap';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import React from 'react';
import Example from './components/Example';

createRoot(document.getElementById('app')).render(<Example />);
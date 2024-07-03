// resources/js/components/Register.jsx
import React from 'react';

export default function Register() {
  return (
    <div className="container">
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header">Register</div>
            <div className="card-body">
              <form method="POST" action="/register">
                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute('content')} />
                <div className="form-group">
                  <label htmlFor="name">Name</label>
                  <input id="name" type="text" className="form-control" name="name" required autoFocus />
                </div>
                <div className="form-group">
                  <label htmlFor="email">E-Mail Address</label>
                  <input id="email" type="email" className="form-control" name="email" required />
                </div>
                <div className="form-group">
                  <label htmlFor="password">Password</label>
                  <input id="password" type="password" className="form-control" name="password" required />
                </div>
                <div className="form-group">
                  <label htmlFor="password-confirm">Confirm Password</label>
                  <input id="password-confirm" type="password" className="form-control" name="password_confirmation" required />
                </div>
                <div className="form-group">
                  <label htmlFor="role">Rol</label>
                  <select className="form-control" id="role" name="role" required>
                    <option value="Cliente">Cliente</option>
                    <option value="Empleado">Empleado</option>
                  </select>
                </div>
                <div className="form-group mb-0">
                  <button type="submit" className="btn btn-primary">Register</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
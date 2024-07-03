import React from 'react';

export default function Login() {
  return (
    <div className="container">
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header">Login</div>
            <div className="card-body">
              <form method="POST" action="/login">
                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute('content')} />
                <div className="form-group">
                  <label htmlFor="email">E-Mail Address</label>
                  <input id="email" type="email" className="form-control" name="email" required autoFocus />
                  {/* Add error handling if needed */}
                </div>
                <div className="form-group">
                  <label htmlFor="password">Password</label>
                  <input id="password" type="password" className="form-control" name="password" required />
                  {/* Add error handling if needed */}
                </div>
                <div className="form-group mb-0">
                  <button type="submit" className="btn btn-primary">Login</button>
                  <a className="btn btn-link" href="/register">Register</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
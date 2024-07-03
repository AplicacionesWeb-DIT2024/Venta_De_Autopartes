import React from 'react';

function Login() {
    return (
        <div>
            <h2>Login</h2>
            <form method="POST" action="/login">
                <div className="form-group">
                    <label htmlFor="email">E-Mail Address</label>
                    <input id="email" type="email" className="form-control" name="email" required autoFocus />
                </div>
                <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input id="password" type="password" className="form-control" name="password" required />
                </div>
                <div className="form-group mb-0">
                    <button type="submit" className="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    );
}

export default Login;
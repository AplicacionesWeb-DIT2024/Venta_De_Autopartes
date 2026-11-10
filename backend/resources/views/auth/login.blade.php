@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form id="loginForm" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                            tabindex="-1">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" id="btnLogin" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a id="btnRegister" class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        toggleIcon.classList.remove('bi-eye');
                        toggleIcon.classList.add('bi-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        toggleIcon.classList.remove('bi-eye-slash');
                        toggleIcon.classList.add('bi-eye');
                    }
                })
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const btnLogin = document.getElementById('btnLogin');
            const btnRegister = document.getElementById('btnRegister');

            if (loginForm) {
                loginForm.addEventListener('submit', function () {
                    // Deshabilitar Register mientras se espera el login
                    if (btnRegister) {
                        btnRegister.classList.add('disabled');
                        btnRegister.style.pointerEvents = 'none';
                        btnRegister.setAttribute('aria-disabled', 'true');
                    }
                    // Feedback en el botón login
                    if (btnLogin) {
                        btnLogin.disabled = true;
                        btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Ingresando...';
                    }
                });
            }
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Campo de contraseña con botón de visibilidad --}}
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

                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm"
                                            tabindex="-1">
                                            <i class="bi bi-eye" id="toggleIconConfirm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (togglePassword && passwordInput && toggleIcon) {
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

            // Confirmar contraseña
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('password-confirm');
            const toggleIconConfirm = document.getElementById('toggleIconConfirm');

            if (togglePasswordConfirm && passwordConfirmInput && toggleIconConfirm) {

                togglePasswordConfirm.addEventListener('click', function () {
                    if (passwordConfirmInput.type === 'password') {
                        passwordConfirmInput.type = 'text';
                        toggleIconConfirm.classList.remove('bi-eye');
                        toggleIconConfirm.classList.add('bi-eye-slash');
                    } else {
                        passwordConfirmInput.type = 'password';
                        toggleIconConfirm.classList.remove('bi-eye-slash');
                        toggleIconConfirm.classList.add('bi-eye');
                    }
                })
            }
        });
    </script>
@endsection
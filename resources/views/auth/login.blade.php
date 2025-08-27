@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/hotel-logo.png') }}" alt="Hotel Logo" style="height:80px;">
                    <h2
                        style="font-family: 'Inter', Arial, sans-serif; font-weight:700; margin-top: 10px; letter-spacing: 0.05em; color: #6366f1;">
                        Welcome Back
                    </h2>
                    <p style="color: #9ca3af;">Sign in to your hotel dashboard</p>
                </div>
                <div class="card shadow-lg" style="border-radius: 1.5rem;">
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label"
                                    style="font-weight:600;">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    style="border-radius: 1.5rem;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label"
                                    style="font-weight:600;">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" style="border-radius: 1.5rem;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4 form-check text-start">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="border-radius: 2rem; font-weight:600;">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

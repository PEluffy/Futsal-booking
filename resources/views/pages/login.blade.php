@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class=" mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                    @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href={{ route('password.request') }}>Forgot Your Password?</a>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endsection
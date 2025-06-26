@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Register</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control" required value="{{ old('email') }}">
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

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
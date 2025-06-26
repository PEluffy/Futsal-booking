@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="text-center">Verify Your Email</h3>

    @if (session('message'))
    <div class="alert alert-success text-center mt-3">
        {{ session('message') }}
    </div>
    @endif

    <p class="text-center mt-3">
        A verification link has been sent to your email address.
        If you didn't receive the email, click below to request another.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="text-center mt-3">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<form class="form-group container mx-auto w-50 my-5" method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" placeholder="email" name="email">
    <button type="submit" class="btn btn-primary mt-5 ">Reset password</button>
</form>
@endsection
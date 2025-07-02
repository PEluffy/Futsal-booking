@extends('admin.layouts.app')

@section('title', 'Add New Facility')

@section('content')
<div class="container mt-4">

    <h1>
        Facilities
    </h1>
    <ul>
        @foreach ($facilities as $facility)
        <li>{{ $facility->name }}</li>
        @endforeach
    </ul>
    <h2>Add New Facility</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Facility Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter facility name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Facility</button>
    </form>
</div>
@endsection
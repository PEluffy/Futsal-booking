@extends('admin.layouts.app')

@section('title', 'Manage Courts')

@section('content')
<div class="container mt-4">

    <!-- Courts comming from the view  -->
    @if ($courts->isEmpty())
    <div class="alert alert-warning">No courts added yet.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($courts as $court)
            <tr>
                <td>{{ $court->id }}</td>
                <td>{{ $court->name }}</td>
                <td>Rs. {{ $court->price }}</td>

                <td>
                    <!-- You can later add edit or delete here -->
                    <form method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this court?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <h2 class="mb-4">Add Courts</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header bg-black text-white">Add New Court</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.create.court') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Court Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" id="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image">Choose a picture:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="form-control" required />
                </div>
                <button type="submit" class="btn bg-black text-white">Add Court</button>
            </form>
        </div>
    </div>

</div>
@endsection
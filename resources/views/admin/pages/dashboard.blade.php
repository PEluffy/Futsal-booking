@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<h1>
    Dashboard
</h1>

<div class=" d-flex gap-5 mt-3">

    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title ">Users</h5>
            <p class="display-1 text-danger"> {{$totalUsers}}</p>
        </div>
    </div>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title ">Facilities</h5>
            <p class="display-1 text-danger"> {{$totalFacilities}}</p>
        </div>
    </div>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title ">Courts</h5>
            <p class="display-1 text-danger"> {{$totalCourts}}</p>
        </div>
    </div>

</div>
@endsection
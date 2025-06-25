@extends('layouts.app')

@section('content')
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR COURTS</h2>
    <div class="h-line bg-primary"></div>
</div>

<div class="container">
    <div class="row">
        @forelse ($courts as $court)
        <div class="col-md-4 mb-4">
            <x-court-card :court="$court" class="h-100" />
        </div>
        @empty
        <div class="col-12">
            <div class="card h-100 text-center p-5">
                No data found
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
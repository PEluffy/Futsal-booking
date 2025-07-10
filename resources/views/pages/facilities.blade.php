@extends('layouts.app')

@section('content')
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-primary"></div>
</div>

<div class="container">
    <div class="row justify-content-center g-4">
        @if (empty($facilities) || count($facilities) == 0)
        <div>Nothing to show</div>
        @else
        @foreach ($facilities as $facility)

        <x-facility-card :facility="$facility" />

        @endforeach
        @endif

    </div>
</div>


@endsection
@section('scripts')
@endsection
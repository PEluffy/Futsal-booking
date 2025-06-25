@extends('layouts.app')

@section('content')
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-primary"></div>
</div>

<div class="container">
    <div class="row">
        @php
        $facilities = [
        [
        'title' => 'Wi-Fi',
        'image' => 'wifi.svg',
        'desc' => 'Free high-speed internet access throughout the facility.'
        ],
        [
        'title' => 'Discounts',
        'image' => 'rs.svg',
        'desc' => 'Great discounts for members and early bookings.'
        ],
        [
        'title' => 'Clean Water',
        'image' => 'love.svg',
        'desc' => 'Stay hydrated with our purified water stations.'
        ],
        [
        'title' => 'Support Line',
        'image' => 'call.svg',
        'desc' => 'Need help? Call our dedicated support anytime.'
        ],

        ];
        @endphp

        @foreach ($facilities as $facility)
        <div class="col-lg-4 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop h-100">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('image/svg/' . $facility['image']) }}" width="40px" alt="{{ $facility['title'] }}">
                    <h5 class="ms-2">{{ $facility['title'] }}</h5>
                </div>
                <p class="mb-0">{{ $facility['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
@endsection
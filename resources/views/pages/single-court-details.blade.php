@extends('layouts.app')

@section('title', $court->name)

@section('content')
<div class="container my-5">
    <!-- Title & Address -->
    <div class="mb-4">
        <h2 class="fw-bold">{{ $court->name }}</h2>
        <p class="text-muted">Kathmandu, Nepal</p> {{-- You can replace with actual address later --}}
    </div>

    <!-- Image -->
    <div class="mb-4 court-img">
        <img src="{{ asset('image/courts/' . $court->image) }}" alt="{{ $court->name }}" class="img-fluid rounded w-100" style="max-height: 400px; object-fit: cover;">
    </div>

    <!-- Info Section -->
    <div class="row g-5">
        <!-- Left Section -->
        <div class="col-lg-8">
            <!-- Court Information -->
            <div class="mb-4">
                <h4 class="fw-semibold">Court Information</h4>
                <div class="row text-muted">
                    <div class="col-md-6"><i class="bi bi-people"></i> Capacity: 10–12 players</div>
                    <div class="col-md-6"><i class="bi bi-clock"></i> Operating Hours: 6AM – 10PM</div>
                </div>
            </div>

            <!-- Facilities -->
            <div class="mb-4">
                <h4 class="fw-semibold">Facilities & Amenities</h4>
                <div class="row">
                    @forelse ($court->facilities as $facility)
                    <div class="col-md-4 mb-2">
                        <i class="bi bi-check-circle-fill text-success me-1 "></i>{{ $facility->name }}
                    </div>
                    @empty
                    <p class="text-muted">No facilities listed.</p>
                    @endforelse
                </div>
            </div>

            <!-- Pricing -->
            <div class="mb-4">
                <h4 class="fw-semibold">Pricing</h4>
                <p class="text-muted">Fixed rate:</p>
                <div class="border rounded p-3">
                    <strong>Rs. {{ $court->price }}</strong> per hour
                </div>
            </div>

            <!-- Additional Info (optional section) -->
            <div class="mb-4">
                <h4 class="fw-semibold">Quick Info</h4>
                <ul class="list-unstyled text-muted">
                    <li><i class="bi bi-grass me-2"></i>Surface Type: Synthetic Grass</li>
                    <li><i class="bi bi-arrows-fullscreen me-2"></i>Court Size: 40m x 20m</li>
                    <li><i class="bi bi-lightbulb me-2"></i>Lighting: LED Floodlights</li>
                    <li><i class="bi bi-calendar-check me-2"></i>Booking Policy: 2 hours advance</li>
                </ul>
            </div>
        </div>

        <!-- Booking Sidebar -->
        <div class="col-lg-4">
            <div class="border p-4 rounded shadow-sm">
                <h5>Book This Court</h5>
                <div class="mb-3">
                    <label class="form-label">Pick a date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Time Slot</label>
                    <select class="form-select">
                        <option selected>Select time</option>
                        <option value="6AM">6AM - 7AM</option>
                        <option value="7AM">7AM - 8AM</option>
                        <!-- Add dynamic time slots later -->
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <select class="form-select">
                        <option selected>1 hour</option>
                        <option>2 hours</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between my-2">
                    <span>Base Price</span>
                    <span>Rs. {{ $court->price }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Service Fee</span>
                    <span>Rs. 100</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total</span>
                    <span>Rs. {{ $court->price + 100 }}</span>
                </div>
                <button class="btn btn-dark w-100">Book Now</button>
            </div>
        </div>
    </div>
</div>
@endsection
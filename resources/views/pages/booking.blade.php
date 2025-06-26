@extends('layouts.app')

@section('content')
@php
// These are mock data for demonstration
$reservedHours = [9, 13]; // Reserved hours (temporary)
$bookedHours = [6, 15]; // Fully booked hours (paid)
@endphp

<div class="container my-5">
    <form method="POST" action="{{ Route('book.reserve') }}">
        @csrf

        <div class="row g-4">
            <!-- Left Section -->
            <div class="col-lg-8">
                <!-- Select Court -->
                <div class="card mb-4">
                    <div class="card-header fw-bold">
                        <i class="bi bi-map"></i> Select Court
                    </div>
                    <div class="card-body">
                        @foreach ($courts as $court)
                        <div class="form-check border p-3 rounded mb-3">
                            <input class="form-check-input" type="radio" name="court_id" id="court{{ $court->id }}" value="{{ $court->id }}" required>
                            <label class="form-check-label w-100" for="court{{ $court->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $court->name }}</h5>
                                        <small class="text-muted">{{ ucfirst($court->type) }}</small>
                                        <div class="mt-1">
                                            @foreach (explode(',', $court->features) as $feature)
                                            <span class="badge bg-secondary me-1">{{ trim($feature) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="fw-bold text-primary">${{ $court->price }}/hour</div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="card mb-4">
                    <div class="card-header fw-bold">
                        <i class="bi bi-calendar-event"></i> Date & Time
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Select Date</label>
                                <input type="date" name="date" class="form-control" min="{{ now()->toDateString() }}" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label">Available Time Slots</label>
                            <input type="hidden" name="selected_hour" id="selected_hour" required>

                            <div class="d-flex flex-wrap gap-2">
                                @for ($i = 6; $i <= 20; $i++)
                                    @php
                                    $isBooked=in_array($i, $bookedHours);
                                    $isReserved=in_array($i, $reservedHours);
                                    $label=$isBooked ? 'Booked' : ($isReserved ? 'Reserved' : 'Available' );
                                    $btnClass=$isBooked ? 'btn-danger disabled' :
                                    ($isReserved ? 'btn-warning disabled' : 'btn-outline-dark selectable-hour' );
                                    @endphp
                                    <button
                                    type="button"
                                    class="btn btn-sm {{ $btnClass }}"
                                    title="{{ $label }}"
                                    data-hour="{{ $i }}">
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                    </button>
                                    @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Player Information -->
                <div class="card mb-4">
                    <div class="card-header fw-bold">
                        <i class="bi bi-people-fill"></i> Player Information
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone number*</label>
                            <input type="number" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Team Name (Optional)</label>
                            <input type="text" class="form-control" name="team_name">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-dark w-100">Reserve</button>
                    <p class="text-success text-center mt-2">This time is reserved for you for 15 mins</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
    document.querySelectorAll('.selectable-hour').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove highlight & white text from all
            document.querySelectorAll('.selectable-hour').forEach(b => {
                b.classList.remove('btn-dark', 'text-white');
            });

            // Highlight selected and make text white
            this.classList.add('btn-dark', 'text-white');

            // Set hidden input value
            document.getElementById('selected_hour').value = this.dataset.hour;
        });
    });
</script>
@endsection


<!-- Right Section (Summary & Payment) -->
<!-- <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Booking Summary
                </div>
                <div class="card-body">
                    <p><strong>Court:</strong> <span id="summaryCourt">-</span></p>
                    <p><strong>Hrs:</strong>-</p>
                    <p><strong>Price:</strong> <span id="summaryPrice">$0</span></p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header fw-bold">
                    Payment Method
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" checked>
                        <label class="form-check-label" for="card">Credit/Debit Card</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash">
                        <label class="form-check-label" for="cash">Pay at Venue</label>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" placeholder="Card Number">
                    </div>
                    <div class="mb-2 d-flex gap-2">
                        <input type="text" class="form-control" placeholder="MM/YY">
                        <input type="text" class="form-control" placeholder="CVV">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms">
                        <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                    </div>
                    <button class="btn btn-dark w-100">Confirm Booking – $0.00</button>
                </div>
            </div>
        </div> -->
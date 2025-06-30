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
    @php
    // These are mock data for demonstration
    $reservedHours = [9, 13]; // Reserved hours (temporary)
    $bookedHours = [6, 15]; // Fully booked hours (paid)
    @endphp

    <div class="container my-5">
        <form method="POST" action="{{ Route('book.court') }}" class="form">
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
                                <input class="form-check-input" type="radio" name="court_id" id="court{{ $court->id }}" value="{{ $court->id }}">
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
                                    <input
                                        type="date"
                                        name="date"
                                        class="form-control"
                                        min="{{ now()->toDateString() }}"
                                        max="{{ now()->addDays(2)->toDateString() }}"
                                        required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">Available Time Slots</label>
                                <input type="hidden" name="time" id="selected_hour" required>

                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                    $startHour = now()->setTimezone('Asia/Kathmandu')->addHour()->format('G');
                                    @endphp
                                    <!-- if user has already reserved a time and court and date we need to display that accodingly if reservation is not outdated -->
                                    @for ($i = $startHour; $i <= 20; $i++)
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
                                <label class="form-label">Team Name </label>
                                <input type="text" class="form-control" name="team_name" required>
                            </div>
                        </div>
                    </div>
                    <p class="error text-danger"></p>
                    <p class="success text-success"></p>
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn btn-dark w-100">Book</button>
                        <p class="text-success text-center mt-2">This time is reserved for you for 15 mins</p>
                    </div>
                </div>
            </div>

        </form>
    </div>
    @endsection
    @section('scripts')
    <script>
        const buttons = document.querySelectorAll('.selectable-hour');
        const hiddenInput = document.getElementById('selected_hour');
        const errorMsg = document.querySelector('.error');
        const successMsg = document.querySelector('.success');

        buttons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const isAlreadySelected = this.classList.contains('btn-dark');
                //for server
                const selectedHour = this.dataset.hour;
                const selectedDate = document.querySelector('input[name="date"]').value;
                const selectedCourtId = document.querySelector('input[name="court_id"]:checked')?.value;
                console.log(selectedDate, selectedHour, selectedCourtId);

                if (!selectedDate || !selectedCourtId) {
                    errorMsg.textContent = 'Please select a court and date first.';
                    return;
                }
                if (isAlreadySelected) {
                    // Unselect the slot
                    buttons.forEach(b => b.classList.remove('btn-dark', 'text-white'));
                    hiddenInput.value = '';
                    errorMsg.textContent = '';
                    return;
                }


                const response = await fetch('/reserve-time', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        court_id: selectedCourtId,
                        date: selectedDate,
                        time: selectedHour,
                    }),
                });


                if (response.redirected) {
                    console.log('redirected');
                    window.location.href = response.url;
                    return;
                }
                const data = await response.json();
                try {

                    if (response.ok) {
                        console.log('response is ok');
                        // Reservation successful, update UI
                        buttons.forEach(b => b.classList.remove('btn-dark', 'text-white'));
                        this.classList.add('btn-dark', 'text-white');
                        hiddenInput.value = selectedHour;
                        errorMsg.textContent = '';
                        successMsg.textContent = data.message;
                    } else {
                        // Reservation failed
                        errorMsg.textContent = data.message || 'This slot is not available.';
                    }

                } catch (error) {
                    errorMsg.textContent = 'Something went wrong';
                }
            });
        });

        // Clear any error message
        errorMsg.textContent = '';

        // Form validation
        document.querySelector('.form').addEventListener('submit', function(e) {
            if (!hiddenInput.value) {
                e.preventDefault();
                errorMsg.textContent = "Note: Please select a time slot before reserving.";
            }
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
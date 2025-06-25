<!-- Facilities -->
<h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">OUR FACILITIES</h2>

<div class="container">
    <div class="row justify-content-center g-4">
        @php
        $facilities = [
        [
        'title' => 'Wi-Fi',
        'image' => 'wifi.svg',
        'alt' => 'Wifi',
        'desc' => 'Free high-speed internet across the entire facility.'
        ],
        [
        'title' => 'Discounts',
        'image' => 'rs.svg',
        'alt' => 'Discount',
        'desc' => 'Special rates for members and recurring bookings.'
        ],
        [
        'title' => 'Clean Water',
        'image' => 'love.svg',
        'alt' => 'Water',
        'desc' => 'Hydration stations available on all courts.'
        ],
        [
        'title' => 'Support Line',
        'image' => 'call.svg',
        'alt' => 'Call',
        'desc' => 'Dedicated helpdesk for your bookings and queries.'
        ],
        ];
        @endphp

        @foreach ($facilities as $facility)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body">
                    <img src="{{ asset('image/svg/' . $facility['image']) }}"
                        alt="{{ $facility['alt'] }}"
                        class="mb-3"
                        style="width: 60px; height: 60px;">
                    <h5 class="card-title fw-semibold">{{ $facility['title'] }}</h5>
                    <p class="text-muted small">{{ $facility['desc'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
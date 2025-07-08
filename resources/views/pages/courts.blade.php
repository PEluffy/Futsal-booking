    @extends('layouts.app')
    @section('content')
    <!-- OUR COURTS -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR COURTS</h2>
    <p class="text-center mb-5 text-muted">Find the perfect court for your game</p>

    <div class="container">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="border rounded p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Filters</h5>
                        <a class="text-decoration-none">Clear All</a>
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label">Search by Name</label>
                        <input type="text" name="name" class="form-control search-text" placeholder="Enter court name..." />
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label">Search by Name</label>
                        <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Enter court name..." />
                    </div> -->

                    <!-- Facilities -->
                    <div class="mb-3">
                        <label class="form-label">Facilities</label>
                        @foreach($facilities as $facility)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility->name }}" id="facility_{{ $loop->index }}">
                            <label class="form-check-label" for="facility_{{ $loop->index }}">{{ $facility->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Range -->
                    <div class="mb-3">
                        <label class="form-label">Price Range</label>
                        <input type="range" class="form-range" min="600" max="5000" step="1" id="priceRange" />
                        <div class="d-flex justify-content-between">
                            <span>Rs. 600</span>
                            <span>Rs. 5000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courts Grid (keep using x-court-card here) -->
            <div class="col-md-9">
                <p class="mb-3">Showing {{ count($courts) }} of {{ $totalCourts ?? count($courts) }} courts</p>
                <div class="row">
                    @forelse($courts as $court)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <x-court-card :court="$court" class="h-100" />
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="card text-center p-5 shadow-sm">
                            <h5 class="text-muted">No courts found.</h5>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')


    <script>
        function debounce(func, delay) {
            let debounceTimeout;
            return function(...args) {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }

        const searchInput = document.querySelector('.search-text');

        const handleInput = debounce(async function(e) {
            const baseUrl = new URL(window.location.href);
            const params = new URLSearchParams(baseUrl.search);
            params.delete('name');
            params.delete('value');
            params.set('name', e.target.value);
            baseUrl.search = params.toString();
            history.replaceState(null, '', baseUrl.toString());

            const courts = await getCourtsDatabyName(e.target.value);
            console.log(courts);
        }, 500);
        searchInput.addEventListener('input', handleInput);
    </script>

    @endsection
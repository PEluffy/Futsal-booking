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
                            <span id="priceLabel">Rs. 5000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courts Grid (keep using x-court-card here) -->
            <div class="col-md-9">
                <p class="mb-3">Showing {{ count($courts) }} of {{ $totalCourts ?? count($courts) }} courts</p>
                <div class="row court-list">
                    @forelse($courts as $court)
                    <div class="col-md-6 col-lg-4 mb-4 ">
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
        const searchInput = document.querySelector('.search-text');

        class CourtFilter {
            constructor() {
                this.searchInput = document.querySelector('.search-text');
                this.priceRange = document.getElementById('priceRange');
                this.priceLabel = document.getElementById('priceLabel');
                this.init();
            }

            renderCourts(data) {
                const container = document.querySelector('.court-list'); // Make sure your container has this class
                container.innerHTML = '';

                if (data.courts.length === 0) {
                    container.innerHTML = '<p>No courts found.</p>';
                    return;
                }
                data.courts.forEach(court => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-6 col-lg-4 mb-4'; // controls layout

                    colDiv.innerHTML = `
        <div class="card h-100">
            <a href="/courts/${court.slug}" class="text-decoration-none text-dark">
                <div class="court-img-container">
                    <img src="/image/courts/${court.image}" alt="${court.name}" class="card-img-top img-court-card" style="aspect-ratio: 3 / 2; object-fit: cover;" width="400" height="300" />
                </div>
                <div class="card-body">
                    <span class="card-title h5 text-primary">${court.name}</span>
                    <p class="card-text mt-1">Price: Rs. ${court.price}</p>
                    <span class="card-text">Type: ${court.type}</span>
                </div>
            </a>
            <div class="text-center mb-2">
                <a href="/booking" class="btn btn-outline-primary mx-2">Book</a>
            </div>
        </div>
    `;

                    container.appendChild(colDiv);
                });

            }

            init() {
                this.loadFiltersFromURL();

                // Debounced event handlers
                this.searchInput.addEventListener('input', this.debounce(() => {
                    this.updateUrl();
                    this.fetchAndDisplayCourts();
                }, 500));

                this.priceRange.addEventListener('input', this.debounce((e) => {
                    this.priceLabel.textContent = `Rs. ${this.priceRange.value}`;
                    this.updateUrl();
                    this.fetchAndDisplayCourts();
                }, 300));
            }
            loadFiltersFromURL() {
                const params = new URLSearchParams(window.location.search);
                const name = params.get('name');
                const price = params.get('price_max');

                if (name) this.searchInput.value = name;
                if (price) {
                    this.priceRange.value = price;
                    this.priceLabel.textContent = `Rs. ${price}`;
                }
            }

            debounce(func, delay) {
                let debounceTimeout;
                return function(...args) {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => {
                        func.apply(this, args);
                    }, delay);
                };
            }
            updateUrl() {
                const url = new URL(window.location.href);
                const params = new URLSearchParams();

                const name = this.searchInput.value.trim();
                const price = this.priceRange.value;

                if (name) params.set('name', name);
                if (price) params.set('price_max', price);

                url.search = params.toString();
                history.pushState(null, '', url.toString());
            }
            async fetchAndDisplayCourts() {
                const params = new URLSearchParams(window.location.search);
                console.log("Searching:", params);
                const res = await fetch(
                    `/courts/search?${params.toString()}`, {
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                    }
                );
                const data = await res.json();
                // Implement your court rendering logic here
                this.renderCourts(data);
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            new CourtFilter();
        });
    </script>

    @endsection
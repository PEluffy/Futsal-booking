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
                    <div class="mb-3">
                        <select class="form-select court-type" name="type">
                            <option value="">Select Type</option>
                            <option value="7A">7A</option>
                            <option value="5A">5A</option>
                            <option value="6A">6A</option>
                        </select>
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
                        <input type="range" class="form-range" min="600" max="5000" step="1" id="priceRange" value="5000" />
                        <div class="d-flex justify-content-between">
                            <span>Rs. 600</span>
                            <span id="priceLabel">Rs. 5000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courts Grid (keep using x-court-card here) -->
            <div class="col-md-9">
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
                <div class="pagination-container ">
                    {!! $courts->links('pagination::bootstrap-5') !!}
                </div>

                <!-- <div class="mt-4 d-flex justify-content-center">
                    <nav aria-label=" Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div> -->
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
                this.courtType = document.querySelector('.court-type');
                this.init();
            }

            renderCourts(data) {
                const container = document.querySelector('.court-list'); // Make sure your container has this class
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = '<p>No courts found.</p>';
                    return;
                }
                data.forEach(court => {
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

                this.courtType.addEventListener('input', () => {
                    this.updateUrl();
                    this.fetchAndDisplayCourts();
                }, 500)

                this.priceRange.addEventListener('input', this.debounce((e) => {
                    this.priceLabel.textContent = `Rs. ${this.priceRange.value}`;
                    this.updateUrl();
                    this.fetchAndDisplayCourts();
                }, 500));
                document.querySelectorAll('input[name="facilities[]"]').forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        this.updateUrl();
                        this.fetchAndDisplayCourts();
                    });
                });
            }
            getCheckedFacilities() {
                return Array.from(
                    document.querySelectorAll('input[name="facilities[]"]:checked')
                ).map(cb => cb.value);
            }

            loadFiltersFromURL() {
                const params = new URLSearchParams(window.location.search);
                const name = params.get('name');
                const price = params.get('price_max');
                const type = params.get('type');
                const facilities = params.getAll('facilities[]');
                facilities.forEach(facility => {
                    const checkbox = document.querySelector(`input[name="facilities[]"][value="${facility}"]`);
                    if (checkbox) checkbox.checked = true;
                });


                if (name) this.searchInput.value = name;
                if (price) {
                    this.priceRange.value = price;
                    this.priceLabel.textContent = `Rs. ${price}`;
                }
                if (type) {
                    this.courtType.value = type;
                }

            }
            renderSkeletons() {
                const container = document.querySelector('.court-list');
                container.innerHTML = ''; // Clear old data

                for (let i = 0; i < 3; i++) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-6 col-lg-4 mb-4';

                    colDiv.innerHTML = `
            <div class="card h-100">
                <a class="text-decoration-none text-dark" >
                    <div class="court-img-container">
                        <div class="skeleton" style="width: 100%; aspect-ratio: 3 / 2;"></div>
                    </div>
                    <div class="card-body">
                        <div class="skeleton-text"></div>
                        <div class="skeleton-text"></div>
                        <div class="skeleton-text"></div>
                    </div>
                </a>
                <div class="text-center mb-2">
                    <div class="skeleton" style="height: 36px; width: 100px; margin: auto;"></div>
                </div>
            </div>
        `;
                    container.appendChild(colDiv);
                }
            }
            renderPagination(linksHtml) {
                const paginationContainer = document.querySelector('.pagination-container');
                paginationContainer.innerHTML = linksHtml;
                this.attachPaginationEvents();
            }

            attachPaginationEvents() {
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const url = new URL(link.href);
                        history.pushState(null, '', url.toString());
                        this.fetchAndDisplayCourts();
                    });
                });
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
                const type = this.courtType.value;
                const facilities = this.getCheckedFacilities();

                if (name) params.set('name', name);
                if (price) params.set('price_max', price);
                if (type && type !== '') params.set('type', type);
                facilities.forEach(facility => {
                    params.append('facilities[]', facility);
                });
                url.search = params.toString();
                history.pushState(null, '', url.toString());
            }
            async fetchAndDisplayCourts() {
                this.renderSkeletons();
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
                this.renderCourts(data.courts.data);
                console.log(data);
                this.renderPagination(data.links);
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            new CourtFilter();
        });
    </script>

    @endsection
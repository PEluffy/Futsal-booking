    @extends('layouts.app')
    @section('content')
    <!-- Reach Us -->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">About US</h2>
        <div class="h-line bg-primary"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe height="320" class="w-100 rounded"
                    src={{ $contact->mapSrc }}
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call us</h5>
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:9869296810" class="d-inline-block mb-2 text-decoration-none text-dark"> {{ $contact->phone }}</a><br>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow us</h5>
                    <a href={{ $contact->twitter }} target="blank" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </span>
                    </a><br>
                    <a href={{ $contact->facebook }} target="blank" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook"></i>Facebook
                        </span>
                    </a><br>
                    <a href={{ $contact->instagram }} target="blank" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram"></i> instagram
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')

    @endsection
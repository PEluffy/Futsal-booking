@props(['facility'])

<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card h-100 text-center border-0 shadow-sm">
        <div class="card-body">
            <img class="mb-3" src="{{ asset('image/svg/' . $facility['name']) .'.svg'}}" alt="{{ $facility['name'] }}" style="width: 60px; height: 60px; ">
            <h5 class="card-title fw-semibold">{{ $facility['name'] }}</h5>
            <p class="text-muted small">{{ $facility['desc'] }}</p>
        </div>

    </div>
</div>
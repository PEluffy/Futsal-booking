@props(['court'])


<div {{ $attributes->merge(['class' => 'card h-100']) }}>
    <a class="text-decoration-none text-dark" href="{{ route('show.court.details', $court->slug) }}">

        <div class="court-img-container">
            <img src="{{ asset('image/courts/' . $court->image) }}"
                class="card-img-top img-court-card"
                alt="{{ $court->name }}"
                width="400"
                height="300"
                style="aspect-ratio: 3 / 2; object-fit: cover;">
        </div>

        <div class="card-body">

            <span class="card-title h5 text-primary">{{ $court->name }}</span>
            <p class="card-text mt-1">Price: Rs. {{ $court->price }}</p>
            <span class="card-text">Type: {{ $court->type }}</span>
        </div>
    </a>

    <div class="text-center mb-2">
        <a href="{{ url('/booking') }}" class="btn btn-outline-primary mx-2">Book</a>
    </div>
</div>